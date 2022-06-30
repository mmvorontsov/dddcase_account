<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMaker;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Trait KeyMakerAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface KeyMakerAdditionInterface
{
    /**
     * @param ContactDataChangeId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfContactDataChange(ContactDataChangeId $id): ?KeyMaker;

    /**
     * @param ContactDataChangeId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfContactDataChangeOrNotFound(ContactDataChangeId $id, string $msg = null): KeyMaker;

    /**
     * @param RegistrationId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfRegistration(RegistrationId $id): ?KeyMaker;

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfRegistrationOrNotFound(RegistrationId $id, string $msg = null): KeyMaker;

    /**
     * @param CredentialRecoveryId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfCredentialRecovery(CredentialRecoveryId $id): ?KeyMaker;

    /**
     * @param CredentialRecoveryId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfCredentialRecoveryOrNotFound(CredentialRecoveryId $id, string $msg = null): KeyMaker;
}
