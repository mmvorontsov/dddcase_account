<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeSelectionSpecInterface;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineContactDataChangeSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine
 */
class DoctrineContactDataChangeSelectionSpecFactory implements ContactDataChangeSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return ContactDataChangeSelectionSpecInterface
     */
    public function createIsLastAndBelongsToUserSelectionSpec(UserId $userId): ContactDataChangeSelectionSpecInterface
    {
        return new DoctrineIsLastAndBelongsToUserSelectionSpec($userId);
    }
}
