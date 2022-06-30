<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

/**
 * Interface UserCredentialResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
interface UserCredentialResponseNormalizerInterface
{
    /**
     * @param UserCredentialResponse $response
     * @return array
     */
    public function toArray(UserCredentialResponse $response): array;
}
