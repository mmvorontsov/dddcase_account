<?php

namespace App\Context\Account\Domain\Service\CreateCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface CreateCredentialRecoveryServiceInterface
 * @package App\Context\Account\Domain\Service\CreateCredentialRecovery
 */
interface CreateCredentialRecoveryServiceInterface
{
    /**
     * @param CreateCredentialRecoveryCommand $command
     * @return CredentialRecovery
     */
    public function execute(CreateCredentialRecoveryCommand $command): CredentialRecovery;
}
