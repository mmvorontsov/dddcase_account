<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Interface KeyMakerSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
interface KeyMakerSelectionSpecFactoryInterface
{
    /**
     * @param RegistrationId $registrationId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToRegistrationSelectionSpec(
        RegistrationId $registrationId,
    ): KeyMakerSelectionSpecInterface;

    /**
     * @param ContactDataChangeId $contactDataChangeId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToContactDataChangeSelectionSpec(
        ContactDataChangeId $contactDataChangeId,
    ): KeyMakerSelectionSpecInterface;

    /**
     * @param CredentialRecoveryId $credentialRecoveryId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToCredentialRecoverySelectionSpec(
        CredentialRecoveryId $credentialRecoveryId,
    ): KeyMakerSelectionSpecInterface;
}
