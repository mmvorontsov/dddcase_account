<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialId;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface CredentialAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface CredentialAdditionInterface
{
    /**
     * @param CredentialId $id
     * @return Credential|null
     */
    public function findById(CredentialId $id): ?Credential;

    /**
     * @param CredentialId $id
     * @param string|null $msg
     * @return Credential
     */
    public function findByIdOrNotFound(CredentialId $id, string $msg = null): Credential;

    /**
     * @param UserId $id
     * @return Credential|null
     */
    public function findCredentialOfUser(UserId $id): ?Credential;

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return Credential
     */
    public function findCredentialOfUserOrNotFound(UserId $id, string $msg = null): Credential;
}
