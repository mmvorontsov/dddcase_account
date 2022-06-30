<?php

namespace App\Context\Account\Application\UseCase\Query\User;

/**
 * Interface UserResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\User
 */
interface UserResponseNormalizerInterface
{
    /**
     * @param UserResponse $response
     * @return array
     */
    public function toArray(UserResponse $response): array;
}
