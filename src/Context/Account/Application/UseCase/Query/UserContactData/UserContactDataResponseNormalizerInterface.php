<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

/**
 * Interface UserContactDataResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
interface UserContactDataResponseNormalizerInterface
{
    /**
     * @param UserContactDataResponse $response
     * @return array
     */
    public function toArray(UserContactDataResponse $response): array;
}
