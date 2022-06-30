<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

/**
 * Interface SignContactDataChangeUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
interface SignContactDataChangeUseCaseInterface
{
    /**
     * @param SignContactDataChangeRequest $request
     * @return SignContactDataChangeResponse
     */
    public function execute(SignContactDataChangeRequest $request): SignContactDataChangeResponse;
}
