<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

/**
 * Interface CreateCredentialRecoverySecretCodeResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
interface CreateCredentialRecoverySecretCodeResponseNormalizerInterface
{
    /**
     * @param CreateCredentialRecoverySecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateCredentialRecoverySecretCodeResponse $response): array;
}
