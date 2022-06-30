<?php

namespace App\Context\Account\Domain\Service\SignCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface SignCredentialRecoveryServiceInterface
 * @package App\Context\Account\Domain\Service\SignCredentialRecovery
 */
interface SignCredentialRecoveryServiceInterface
{
    /**
     * @param SignCredentialRecoveryCommand $command
     * @return CredentialRecovery
     */
    public function execute(SignCredentialRecoveryCommand $command): CredentialRecovery;
}
