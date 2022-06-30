<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

/**
 * Interface UserByCredentialResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
interface UserByCredentialResponseNormalizerInterface
{
    /**
     * @param UserByCredentialResponse $response
     * @return array
     */
    public function toArray(UserByCredentialResponse $response): array;
}
