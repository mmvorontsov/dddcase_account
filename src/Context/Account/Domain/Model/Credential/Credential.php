<?php

namespace App\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\Credential\PasswordHistory\PasswordHistory;
use App\Context\Account\Domain\Model\Credential\Update\CredentialPasswordUpdated;
use App\Context\Account\Domain\Model\Credential\Update\CredentialUsernameUpdated;
use App\Context\Account\Domain\Model\Credential\Update\UpdateCredentialCommand;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

use function sprintf;

/**
 * Class Credential
 * @package App\Context\Account\Domain\Model\Credential
 */
class Credential implements AggregateRootInterface
{
    public const PASSWORD_CHANGE_DAILY_LIMIT = 2;
    private const PASSWORD_HISTORY_LENGTH = 4; // It must be greater than or equal to PASSWORD_CHANGE_DAILY_LIMIT

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var CredentialId
     */
    private CredentialId $credentialId;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var string
     */
    private string $hashedPassword;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection
     */
    protected Collection $passwordHistory;

    /**
     * Credential constructor.
     * @param CredentialId $credentialId
     * @param UserId $userId
     * @param string|null $username
     * @param string $hashedPassword
     * @param DateTimeImmutable $createdAt
     * @param Collection $passwordHistory
     */
    public function __construct(
        UserId $userId,
        CredentialId $credentialId,
        ?string $username,
        string $hashedPassword,
        DateTimeImmutable $createdAt,
        Collection $passwordHistory,
    ) {
        $this->userId = $userId;
        $this->credentialId = $credentialId;
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
        $this->createdAt = $createdAt;
        $this->passwordHistory = $passwordHistory;
    }

    /**
     * @param CreateCredentialCommand $command
     * @return Credential
     * @throws Exception
     */
    public static function create(CreateCredentialCommand $command): Credential
    {
        $credential = new self(
            $command->getUserId(),
            CredentialId::create(),
            $command->getUsername(),
            $command->getHashedPassword(),
            new DateTimeImmutable(),
            new ArrayCollection(),
        );

        DomainEventSubject::instance()->notify(
            new CredentialCreated($credential),
        );

        return $credential;
    }

    /**
     * @param UpdateCredentialCommand $command
     */
    public function update(UpdateCredentialCommand $command): void
    {
        $updateMethods = [
            UpdateCredentialCommand::HASHED_PASSWORD => function ($hashedPassword) {
                $this->updateHashedPassword($hashedPassword);
            },
            UpdateCredentialCommand::USERNAME => function ($username) {
                $this->updateUsername($username);
            },
        ];

        foreach ($command->all() as $propKey => $args) {
            if ($updateMethod = $updateMethods[$propKey] ?? null) {
                $updateMethod(...$args);
            }
        }
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return CredentialId
     */
    public function getCredentialId(): CredentialId
    {
        return $this->credentialId;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection
     */
    public function getPasswordHistory(): Collection
    {
        return $this->passwordHistory;
    }

    /**
     * @param string $hashedPassword
     * @throws Exception
     */
    private function updateHashedPassword(string $hashedPassword): void
    {
        $spec = new CredentialWithReachedDailyLimitOfPasswordChangeSpec();
        if ($spec->isSatisfiedBy($this)) {
            $dailyLimit = self::PASSWORD_CHANGE_DAILY_LIMIT;
            throw new DomainException(
                sprintf('Password change daily limit (%d times) reached.', $dailyLimit),
            );
        }

        $this->passwordHistory->add(PasswordHistory::create($this, $hashedPassword));
        $this->trimPasswordHistory();
        $this->hashedPassword = $hashedPassword;

        DomainEventSubject::instance()->notify(
            new CredentialPasswordUpdated($this),
        );
    }

    /**
     * @param string|null $username
     * @throws Exception
     */
    private function updateUsername(?string $username): void
    {
        $fromUsername = $this->getUsername();
        $this->username = $username;

        DomainEventSubject::instance()->notify(
            new CredentialUsernameUpdated($this, $fromUsername),
        );
    }

    /**
     * @return void
     */
    private function trimPasswordHistory(): void
    {
        $length = self::PASSWORD_HISTORY_LENGTH;
        if ($this->passwordHistory->count() <= $length) {
            return;
        }

        $toRemove = $this->passwordHistory->count() - $length;
        foreach ($this->passwordHistory as $key => $passwordHistory) {
            if ($toRemove <= 0) {
                break;
            }
            $this->passwordHistory->remove($key);
            $toRemove--;
        }
    }
}
