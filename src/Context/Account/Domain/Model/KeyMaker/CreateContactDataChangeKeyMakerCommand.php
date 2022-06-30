<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;

/**
 * Class CreateContactDataChangeKeyMakerCommand
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
final class CreateContactDataChangeKeyMakerCommand
{
    /**
     * @var PrimaryContactData
     */
    private PrimaryContactData $primaryContactData;

    /**
     * @var ContactDataChangeId
     */
    private ContactDataChangeId $contactDataChangeId;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * CreateRegistrationKeyMakerCommand constructor.
     * @param PrimaryContactData $primaryContactData
     * @param ContactDataChangeId $contactDataChangeId
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        PrimaryContactData $primaryContactData,
        ContactDataChangeId $contactDataChangeId,
        DateTimeImmutable $expiredAt,
    ) {
        $this->primaryContactData = $primaryContactData;
        $this->contactDataChangeId = $contactDataChangeId;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @return PrimaryContactData
     */
    public function getPrimaryContactData(): PrimaryContactData
    {
        return $this->primaryContactData;
    }

    /**
     * @return ContactDataChangeId
     */
    public function getContactDataChangeId(): ContactDataChangeId
    {
        return $this->contactDataChangeId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
