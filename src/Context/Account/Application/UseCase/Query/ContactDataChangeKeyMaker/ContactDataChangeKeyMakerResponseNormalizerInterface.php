<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

/**
 * Interface ContactDataChangeKeyMakerResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
interface ContactDataChangeKeyMakerResponseNormalizerInterface
{
    /**
     * @param ContactDataChangeKeyMakerResponse $response
     * @return array
     */
    public function toArray(ContactDataChangeKeyMakerResponse $response): array;
}
