<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

/**
 * Interface CreateRegistrationResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
interface CreateRegistrationResponseNormalizerInterface
{
    /**
     * @param CreateRegistrationResponse $response
     * @return array
     */
    public function toArray(CreateRegistrationResponse $response): array;
}
