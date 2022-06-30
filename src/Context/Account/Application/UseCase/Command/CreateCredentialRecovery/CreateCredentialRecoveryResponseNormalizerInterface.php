<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

/**
 * Interface CreateCredentialRecoveryResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
interface CreateCredentialRecoveryResponseNormalizerInterface
{
    /**
     * @param CreateCredentialRecoveryResponse $response
     * @return array
     */
    public function toArray(CreateCredentialRecoveryResponse $response): array;
}
