<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;

/**
 * Class ContactDataChange
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
abstract class ContactDataChange implements AggregateRootInterface
{
    /**
     * @var UserId
     */
    protected UserId $userId;

    /**
     * @var ContactDataChangeId
     */
    protected ContactDataChangeId $contactDataChangeId;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * ContactDataChange constructor.
     * @param UserId $userId
     * @param ContactDataChangeId $contactDataChangeId
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    protected function __construct(
        UserId $userId,
        ContactDataChangeId $contactDataChangeId,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->userId = $userId;
        $this->contactDataChangeId = $contactDataChangeId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @return PrimaryContactData
     */
    abstract public function getToValue(): PrimaryContactData;

    /**
     * @return void
     */
    public function sign(): void
    {
        if (ContactDataChangeStatusEnum::SIGNING !== $this->status) {
            throw new DomainException('Contact data change has invalid status for signing.');
        }

        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Contact data change has expired.');
        }

        $this->status = ContactDataChangeStatusEnum::DONE;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return ContactDataChangeId
     */
    public function getContactDataChangeId(): ContactDataChangeId
    {
        return $this->contactDataChangeId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
