<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

/**
 * Interface UpdateUserCredentialPasswordResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
interface UpdateUserCredentialPasswordResponseNormalizerInterface
{
    /**
     * @param UpdateUserCredentialPasswordResponse $response
     * @return array
     */
    public function toArray(UpdateUserCredentialPasswordResponse $response): array;
}
