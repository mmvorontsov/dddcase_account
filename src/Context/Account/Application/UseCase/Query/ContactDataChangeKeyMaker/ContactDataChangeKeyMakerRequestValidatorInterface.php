<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface ContactDataChangeKeyMakerRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
interface ContactDataChangeKeyMakerRequestValidatorInterface
{
    /**
     * @param ContactDataChangeKeyMakerRequest $request
     * @return ErrorListInterface
     */
    public function validate(ContactDataChangeKeyMakerRequest $request): ErrorListInterface;
}
