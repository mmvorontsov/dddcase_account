<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

/**
 * Interface CreateContactDataChangeUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
interface CreateContactDataChangeUseCaseInterface
{
    /**
     * @param CreateContactDataChangeRequest $request
     * @return CreateContactDataChangeResponse
     */
    public function execute(CreateContactDataChangeRequest $request): CreateContactDataChangeResponse;
}
