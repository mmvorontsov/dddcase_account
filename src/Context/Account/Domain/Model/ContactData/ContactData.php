<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataEmailUpdated;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataPhoneUpdated;
use App\Context\Account\Domain\Model\ContactData\Update\UpdateContactDataCommand;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

use function sprintf;

/**
 * Class ContactData
 * @package App\Context\Account\Domain\Model\ContactData
 */
class ContactData implements AggregateRootInterface
{
    public const EMAIL_CHANGE_DAILY_LIMIT = 2;
    public const PHONE_CHANGE_DAILY_LIMIT = 2;
    public const EMAIL_HISTORY_LENGTH = 4; // It must be greater than or equal to EMAIL_CHANGE_DAILY_LIMIT
    public const PHONE_HISTORY_LENGTH = 4; // It must be greater than or equal to PHONE_CHANGE_DAILY_LIMIT

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var ContactDataId
     */
    private ContactDataId $contactDataId;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $email;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $phone;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection
     */
    private Collection $emailHistory;

    /**
     * @var Collection
     */
    private Collection $phoneHistory;

    /**
     * ContactData constructor.
     * @param UserId $userId
     * @param ContactDataId $contactDataId
     * @param EmailAddress|null $email
     * @param PhoneNumber|null $phone
     * @param DateTimeImmutable $createdAt
     * @param Collection $emailHistory
     * @param Collection $phoneHistory
     */
    public function __construct(
        UserId $userId,
        ContactDataId $contactDataId,
        ?EmailAddress $email,
        ?PhoneNumber $phone,
        DateTimeImmutable $createdAt,
        Collection $emailHistory,
        Collection $phoneHistory,
    ) {
        $this->userId = $userId;
        $this->contactDataId = $contactDataId;
        $this->email = $email;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
        $this->emailHistory = $emailHistory;
        $this->phoneHistory = $phoneHistory;
    }

    /**
     * @param CreateContactDataCommand $command
     * @return ContactData
     * @throws Exception
     */
    public static function create(CreateContactDataCommand $command): ContactData
    {
        if (null === $command->getEmail() && null === $command->getPhone()) {
            throw new DomainException('Email or phone number must be specified.');
        }

        $contactData = new self(
            $command->getUserId(),
            ContactDataId::create(),
            $command->getEmail(),
            $command->getPhone(),
            new DateTimeImmutable(),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        DomainEventSubject::instance()->notify(
            new ContactDataCreated($contactData),
        );

        return $contactData;
    }

    /**
     * @param UpdateContactDataCommand $command
     */
    public function update(UpdateContactDataCommand $command): void
    {
        $updateMethods = [
            UpdateContactDataCommand::EMAIL => function (EmailAddress $email) {
                $this->updateEmail($email);
            },
            UpdateContactDataCommand::PHONE => function (PhoneNumber $phone) {
                $this->updatePhone($phone);
            },
        ];

        foreach ($command->all() as $propKey => $args) {
            if ($updateMethod = $updateMethods[$propKey] ?? null) {
                $updateMethod(...$args);
            }
        }
    }

    /**
     * @param EmailAddress $email
     * @throws Exception
     */
    private function updateEmail(EmailAddress $email): void
    {
        $spec = new ContactDataWithReachedDailyLimitOfEmailChangeSpec();
        if ($spec->isSatisfiedBy($this)) {
            $dailyLimit = self::EMAIL_CHANGE_DAILY_LIMIT;
            throw new DomainException(
                sprintf('Email change daily limit (%d times) reached.', $dailyLimit),
            );
        }

        $fromEmail = $this->getEmail();
        $this->emailHistory->add(EmailHistory::create($this, $fromEmail));
        $this->trimHistory($this->emailHistory, self::EMAIL_HISTORY_LENGTH);
        $this->email = $email;

        DomainEventSubject::instance()->notify(
            new ContactDataEmailUpdated($this, $fromEmail),
        );
    }

    /**
     * @param PhoneNumber $phone
     * @throws Exception
     */
    private function updatePhone(PhoneNumber $phone): void
    {
        $spec = new ContactDataWithReachedDailyLimitOfPhoneChangeSpec();
        if ($spec->isSatisfiedBy($this)) {
            $dailyLimit = self::PHONE_CHANGE_DAILY_LIMIT;
            throw new DomainException(
                sprintf('Phone change daily limit (%d times) reached.', $dailyLimit),
            );
        }

        $fromPhone = $this->getPhone();
        $this->phoneHistory->add(PhoneHistory::create($this, $fromPhone));
        $this->trimHistory($this->phoneHistory, self::PHONE_HISTORY_LENGTH);
        $this->phone = $phone;

        DomainEventSubject::instance()->notify(
            new ContactDataPhoneUpdated($this, $fromPhone),
        );
    }

    /**
     * @param Collection $history
     * @param int $length
     */
    private function trimHistory(Collection $history, int $length): void
    {
        if ($history->count() <= $length) {
            return;
        }

        $toRemove = $history->count() - $length;
        foreach ($history as $key => $item) {
            if ($toRemove <= 0) {
                break;
            }
            $history->remove($key);
            $toRemove--;
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
     * @return ContactDataId
     */
    public function getContactDataId(): ContactDataId
    {
        return $this->contactDataId;
    }

    /**
     * @return EmailAddress|null
     */
    public function getEmail(): ?EmailAddress
    {
        return $this->email;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
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
    public function getEmailHistory(): Collection
    {
        return $this->emailHistory;
    }

    /**
     * @return Collection
     */
    public function getPhoneHistory(): Collection
    {
        return $this->phoneHistory;
    }
}
