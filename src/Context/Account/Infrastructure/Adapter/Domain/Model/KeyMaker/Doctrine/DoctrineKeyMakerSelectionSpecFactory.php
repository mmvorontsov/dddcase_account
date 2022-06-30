<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class DoctrineKeyMakerSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
class DoctrineKeyMakerSelectionSpecFactory implements KeyMakerSelectionSpecFactoryInterface
{
    /**
     * @param RegistrationId $registrationId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToRegistrationSelectionSpec(
        RegistrationId $registrationId,
    ): KeyMakerSelectionSpecInterface {
        return new DoctrineBelongsToRegistrationSelectionSpec($registrationId);
    }

    /**
     * @param ContactDataChangeId $contactDataChangeId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToContactDataChangeSelectionSpec(
        ContactDataChangeId $contactDataChangeId,
    ): KeyMakerSelectionSpecInterface {
        return new DoctrineBelongsToContactDataChangeSelectionSpec($contactDataChangeId);
    }

    /**
     * @param CredentialRecoveryId $credentialRecoveryId
     * @return KeyMakerSelectionSpecInterface
     */
    public function createBelongsToCredentialRecoverySelectionSpec(
        CredentialRecoveryId $credentialRecoveryId,
    ): KeyMakerSelectionSpecInterface {
        return new DoctrineBelongsToCredentialRecoverySelectionSpec($credentialRecoveryId);
    }
}
