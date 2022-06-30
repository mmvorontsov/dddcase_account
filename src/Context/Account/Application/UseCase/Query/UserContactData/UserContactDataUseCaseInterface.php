<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

/**
 * Interface UserContactDataUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
interface UserContactDataUseCaseInterface
{
    /**
     * @param UserContactDataRequest $request
     * @return UserContactDataResponse
     */
    public function execute(UserContactDataRequest $request): UserContactDataResponse;
}
