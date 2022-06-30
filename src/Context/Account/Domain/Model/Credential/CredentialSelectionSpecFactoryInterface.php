<?php

namespace App\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface CredentialSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\Credential
 */
interface CredentialSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return CredentialSelectionSpecInterface
     */
    public function createBelongsToUserSelectionSpec(UserId $userId): CredentialSelectionSpecInterface;

    /**
     * @param string $username
     * @return CredentialSelectionSpecInterface
     */
    public function createHasUsernameSelectionSpec(string $username): CredentialSelectionSpecInterface;
}
