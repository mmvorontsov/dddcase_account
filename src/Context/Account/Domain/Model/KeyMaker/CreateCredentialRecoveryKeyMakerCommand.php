<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;

/**
 * Class CreateCredentialRecoveryKeyMakerCommand
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
final class CreateCredentialRecoveryKeyMakerCommand
{
    /**
     * @var PrimaryContactData
     */
    private PrimaryContactData $primaryContactData;

    /**
     * @var CredentialRecoveryId
     */
    private CredentialRecoveryId $credentialRecoveryId;

    /**
     * @var bool
     */
    private bool $isMute;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * CreateRegistrationKeyMakerCommand constructor.
     * @param PrimaryContactData $primaryContactData
     * @param CredentialRecoveryId $credentialRecoveryId
     * @param bool $isMute
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        PrimaryContactData $primaryContactData,
        CredentialRecoveryId $credentialRecoveryId,
        bool $isMute,
        DateTimeImmutable $expiredAt,
    ) {
        $this->primaryContactData = $primaryContactData;
        $this->credentialRecoveryId = $credentialRecoveryId;
        $this->isMute = $isMute;
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
     * @return CredentialRecoveryId
     */
    public function getCredentialRecoveryId(): CredentialRecoveryId
    {
        return $this->credentialRecoveryId;
    }

    /**
     * @return bool
     */
    public function getIsMute(): bool
    {
        return $this->isMute;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
