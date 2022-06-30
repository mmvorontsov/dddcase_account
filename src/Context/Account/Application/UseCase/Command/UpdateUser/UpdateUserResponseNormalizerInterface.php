<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

/**
 * Interface UpdateUserResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 */
interface UpdateUserResponseNormalizerInterface
{
    /**
     * @param UpdateUserResponse $response
     * @return array
     */
    public function toArray(UpdateUserResponse $response): array;
}
