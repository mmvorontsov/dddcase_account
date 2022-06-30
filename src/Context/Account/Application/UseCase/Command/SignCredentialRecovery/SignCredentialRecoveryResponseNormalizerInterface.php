<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

/**
 * Interface SignCredentialRecoveryResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
interface SignCredentialRecoveryResponseNormalizerInterface
{
    /**
     * @param SignCredentialRecoveryResponse $response
     * @return array
     */
    public function toArray(SignCredentialRecoveryResponse $response): array;
}
