<?php

namespace App\Context\Account\Domain\Service\SignContactDataChange;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Interface SignContactDataChangeServiceInterface
 * @package App\Context\Account\Domain\Service\SignContactDataChange
 */
interface SignContactDataChangeServiceInterface
{
    /**
     * @param SignContactDataChangeCommand $command
     * @return ContactDataChange
     */
    public function execute(SignContactDataChangeCommand $command): ContactDataChange;
}
