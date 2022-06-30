<?php

namespace App\Context\Account\Domain\Service\CreateCredentialRecovery;

use App\Context\Account\Domain\Common\Type\PrimaryContactData;

/**
 * Class CreateCredentialRecoveryCommand
 * @package App\Context\Account\Domain\Service\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryCommand
{
    /**
     * @var PrimaryContactData
     */
    private PrimaryContactData $primaryContactData;

    /**
     * CreateCredentialRecoveryCommand constructor.
     * @param PrimaryContactData $primaryContactData
     */
    public function __construct(PrimaryContactData $primaryContactData)
    {
        $this->primaryContactData = $primaryContactData;
    }

    /**
     * @return PrimaryContactData
     */
    public function getPrimaryContactData(): PrimaryContactData
    {
        return $this->primaryContactData;
    }
}
