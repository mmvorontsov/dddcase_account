<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface ContactDataChangeSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
interface ContactDataChangeSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return ContactDataChangeSelectionSpecInterface
     */
    public function createIsLastAndBelongsToUserSelectionSpec(UserId $userId): ContactDataChangeSelectionSpecInterface;
}
