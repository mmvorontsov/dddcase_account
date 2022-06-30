<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

/**
 * Interface SignRegistrationResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
interface SignRegistrationResponseNormalizerInterface
{
    /**
     * @param SignRegistrationResponse $response
     * @return array
     */
    public function toArray(SignRegistrationResponse $response): array;
}
