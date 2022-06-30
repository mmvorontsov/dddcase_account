<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

/**
 * Interface CreateRegistrationSecretCodeResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
interface CreateRegistrationSecretCodeResponseNormalizerInterface
{
    /**
     * @param CreateRegistrationSecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateRegistrationSecretCodeResponse $response): array;
}
