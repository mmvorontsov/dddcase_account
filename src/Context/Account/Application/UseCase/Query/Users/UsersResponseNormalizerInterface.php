<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

/**
 * Interface UsersResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
interface UsersResponseNormalizerInterface
{
    /**
     * @param UsersResponse $response
     * @return array
     */
    public function toArray(UsersResponse $response): array;
}
