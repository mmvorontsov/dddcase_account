<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

/**
 * Interface CreateContactDataChangeResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
interface CreateContactDataChangeResponseNormalizerInterface
{
    /**
     * @param CreateContactDataChangeResponse $response
     * @return array
     */
    public function toArray(CreateContactDataChangeResponse $response): array;
}
