<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

/**
 * Interface CreateContactDataChangeSecretCodeResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode
 */
interface CreateContactDataChangeSecretCodeResponseNormalizerInterface
{
    /**
     * @param CreateContactDataChangeSecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateContactDataChangeSecretCodeResponse $response): array;
}
