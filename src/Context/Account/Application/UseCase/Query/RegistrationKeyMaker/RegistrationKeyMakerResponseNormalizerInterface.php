<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

/**
 * Interface RegistrationKeyMakerResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
interface RegistrationKeyMakerResponseNormalizerInterface
{
    /**
     * @param RegistrationKeyMakerResponse $response
     * @return array
     */
    public function toArray(RegistrationKeyMakerResponse $response): array;
}
