<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

/**
 * Interface SignContactDataChangeResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
interface SignContactDataChangeResponseNormalizerInterface
{
    /**
     * @param SignContactDataChangeResponse $response
     * @return array
     */
    public function toArray(SignContactDataChangeResponse $response): array;
}
