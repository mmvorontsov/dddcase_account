<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker\{
    ContactDataChangeKeyMakerRequest as UseCaseRequest,
    ContactDataChangeKeyMakerResponse as UseCaseResponse,
};

/**
 * Interface ContactDataChangeKeyMakerUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
interface ContactDataChangeKeyMakerUseCaseInterface
{
    /**
     * @param UseCaseRequest $request
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $request): UseCaseResponse;
}
