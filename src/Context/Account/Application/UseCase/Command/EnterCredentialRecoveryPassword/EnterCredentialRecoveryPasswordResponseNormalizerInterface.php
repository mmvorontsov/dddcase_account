<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

/**
 * Interface EnterCredentialRecoveryPasswordResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
interface EnterCredentialRecoveryPasswordResponseNormalizerInterface
{
    /**
     * @param EnterCredentialRecoveryPasswordResponse $response
     * @return array
     */
    public function toArray(EnterCredentialRecoveryPasswordResponse $response): array;
}
