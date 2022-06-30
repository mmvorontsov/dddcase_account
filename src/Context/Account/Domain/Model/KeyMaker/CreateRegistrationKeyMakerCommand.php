<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class CreateRegistrationKeyMakerCommand
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
final class CreateRegistrationKeyMakerCommand
{
    /**
     * @var PrimaryContactData
     */
    private PrimaryContactData $primaryContactData;

    /**
     * @var RegistrationId
     */
    private RegistrationId $registrationId;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * CreateRegistrationKeyMakerCommand constructor.
     * @param PrimaryContactData $primaryContactData
     * @param RegistrationId $registrationId
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        PrimaryContactData $primaryContactData,
        RegistrationId $registrationId,
        DateTimeImmutable $expiredAt,
    ) {
        $this->primaryContactData = $primaryContactData;
        $this->registrationId = $registrationId;
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
     * @return RegistrationId
     */
    public function getRegistrationId(): RegistrationId
    {
        return $this->registrationId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
