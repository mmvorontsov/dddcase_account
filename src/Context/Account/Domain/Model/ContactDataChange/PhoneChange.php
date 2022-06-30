<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\User\UserId;

use function sprintf;

/**
 * Class PhoneChange
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class PhoneChange extends ContactDataChange
{
    private const LIFETIME = 3600;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $fromPhone;

    /**
     * @var PhoneNumber
     */
    private PhoneNumber $toPhone;

    /**
     * PhoneChange constructor.
     * @param ContactDataChangeId $contactDataChangeId
     * @param UserId $userId
     * @param string $status
     * @param PhoneNumber|null $fromPhone
     * @param PhoneNumber $toPhone
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        UserId $userId,
        ContactDataChangeId $contactDataChangeId,
        string $status,
        ?PhoneNumber $fromPhone,
        PhoneNumber $toPhone,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt
    ) {
        parent::__construct(
            $userId,
            $contactDataChangeId,
            $status,
            $createdAt,
            $expiredAt,
        );

        $this->fromPhone = $fromPhone;
        $this->toPhone = $toPhone;
    }

    /**
     * @param CreatePhoneChangeCommand $command
     * @return PhoneChange
     * @throws Exception
     */
    public static function create(CreatePhoneChangeCommand $command): PhoneChange
    {
        $contactDataChange = new self(
            $command->getUserId(),
            ContactDataChangeId::create(),
            ContactDataChangeStatusEnum::SIGNING,
            $command->getFromPhone(),
            $command->getToPhone(),
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', self::LIFETIME)),
        );

        DomainEventSubject::instance()->notify(
            new ContactDataChangeCreated($contactDataChange),
        );

        return $contactDataChange;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getFromPhone(): ?PhoneNumber
    {
        return $this->fromPhone;
    }

    /**
     * @return PhoneNumber
     */
    public function getToPhone(): PhoneNumber
    {
        return $this->toPhone;
    }

    /**
     * @return PrimaryContactData
     */
    public function getToValue(): PrimaryContactData
    {
        return $this->toPhone;
    }
}
