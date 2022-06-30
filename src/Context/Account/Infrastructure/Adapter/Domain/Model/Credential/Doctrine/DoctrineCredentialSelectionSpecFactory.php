<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine;

use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecInterface;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineCredentialSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine
 */
class DoctrineCredentialSelectionSpecFactory implements CredentialSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return CredentialSelectionSpecInterface
     */
    public function createBelongsToUserSelectionSpec(UserId $userId): CredentialSelectionSpecInterface
    {
        return new DoctrineBelongsToUserSelectionSpec($userId);
    }

    /**
     * @param string $username
     * @return CredentialSelectionSpecInterface
     */
    public function createHasUsernameSelectionSpec(string $username): CredentialSelectionSpecInterface
    {
        return new DoctrineHasUsernameSelectionSpec($username);
    }
}
