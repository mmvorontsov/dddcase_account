<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Common\Util\StringUtil;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCodeEnum;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class CredentialRecovery
 * @package App\Context\Account\Domain\Model\CredentialRecovery
 */
class CredentialRecovery implements AggregateRootInterface
{
    public const LIFETIME = 3600; // in seconds
    public const PASSWORD_ENTRY_CODE_LENGTH = 60;

    /**
     * @var UserId|null
     */
    private ?UserId $userId;

    /**
     * @var CredentialRecoveryId
     */
    private CredentialRecoveryId $credentialRecoveryId;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $byEmail;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $byPhone;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var string|null
     */
    private ?string $passwordEntryCode;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * CredentialRecovery constructor.
     * @param UserId|null $userId
     * @param CredentialRecoveryId $credentialRecoveryId
     * @param EmailAddress|null $byEmail
     * @param PhoneNumber|null $byPhone
     * @param string $status
     * @param string|null $passwordEntryCode
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        ?UserId $userId,
        CredentialRecoveryId $credentialRecoveryId,
        ?EmailAddress $byEmail,
        ?PhoneNumber $byPhone,
        string $status,
        ?string $passwordEntryCode,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->userId = $userId;
        $this->credentialRecoveryId = $credentialRecoveryId;
        $this->byEmail = $byEmail;
        $this->byPhone = $byPhone;
        $this->status = $status;
        $this->passwordEntryCode = $passwordEntryCode;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param PrimaryContactData $primaryContactData
     * @param UserId|null $userId
     * @return CredentialRecovery
     * @throws Exception
     */
    public static function create(PrimaryContactData $primaryContactData, ?UserId $userId): CredentialRecovery
    {
        $credentialRecovery = new self(
            $userId,
            CredentialRecoveryId::create(),
            $primaryContactData->getEmailAddressOrNull(),
            $primaryContactData->getPhoneNumberOrNull(),
            CredentialRecoveryStatusEnum::SIGNING,
            null,
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', self::LIFETIME)),
        );

        DomainEventSubject::instance()->notify(
            new CredentialRecoveryCreated($credentialRecovery),
        );

        return $credentialRecovery;
    }

    /**
     * @throws Exception
     */
    public function sign(): void
    {
        if (CredentialRecoveryStatusEnum::SIGNING !== $this->status) {
            throw new DomainException('Credential recovery has invalid status for signing.');
        }

        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Credential recovery has expired.');
        }

        $this->status = CredentialRecoveryStatusEnum::PASSWORD_ENTRY;
        $this->passwordEntryCode = StringUtil::generate(self::PASSWORD_ENTRY_CODE_LENGTH);
    }

    /**
     * @param string $passwordEntryCode
     */
    public function enterPassword(string $passwordEntryCode): void
    {
        if (CredentialRecoveryStatusEnum::PASSWORD_ENTRY !== $this->status) {
            throw new DomainException('Credential recovery has invalid status for password entry.');
        }

        if ($passwordEntryCode !== $this->passwordEntryCode) {
            throw new DomainException('Password entry code corrupted.');
        }

        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Credential recovery has expired.');
        }

        $this->status = CredentialRecoveryStatusEnum::DONE;
    }

    /**
     * @param UserId $userId
     */
    public function updateUserId(UserId $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return PrimaryContactData
     */
    public function getBy(): PrimaryContactData
    {
        return $this->getByEmail() ?? $this->getByPhone();
    }

    /**
     * @return UserId|null
     */
    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    /**
     * @return CredentialRecoveryId
     */
    public function getCredentialRecoveryId(): CredentialRecoveryId
    {
        return $this->credentialRecoveryId;
    }

    /**
     * @return EmailAddress|null
     */
    public function getByEmail(): ?EmailAddress
    {
        return $this->byEmail;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getByPhone(): ?PhoneNumber
    {
        return $this->byPhone;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getPasswordEntryCode(): ?string
    {
        return $this->passwordEntryCode;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
