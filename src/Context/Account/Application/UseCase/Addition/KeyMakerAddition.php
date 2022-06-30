<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class KeyMakerAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class KeyMakerAddition implements KeyMakerAdditionInterface
{
    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * @var KeyMakerSelectionSpecFactoryInterface
     */
    private KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory;

    /**
     * KeyMakerAddition constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
    }

    /**
     * @param ContactDataChangeId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfContactDataChange(ContactDataChangeId $id): ?KeyMaker
    {
        return $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToContactDataChangeSelectionSpec($id),
        );
    }

    /**
     * @param ContactDataChangeId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfContactDataChangeOrNotFound(ContactDataChangeId $id, string $msg = null): KeyMaker
    {
        $keyMaker = $this->findKeyMakerOfContactDataChange($id);
        if (null === $keyMaker) {
            throw new NotFoundException($msg ?? 'Key maker not found.');
        }

        return $keyMaker;
    }

    /**
     * @param RegistrationId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfRegistration(RegistrationId $id): ?KeyMaker
    {
        return $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToRegistrationSelectionSpec($id),
        );
    }

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfRegistrationOrNotFound(RegistrationId $id, string $msg = null): KeyMaker
    {
        $keyMaker = $this->findKeyMakerOfRegistration($id);
        if (null === $keyMaker) {
            throw new NotFoundException($msg ?? 'Key maker not found.');
        }

        return $keyMaker;
    }

    /**
     * @param CredentialRecoveryId $id
     * @return KeyMaker|null
     */
    public function findKeyMakerOfCredentialRecovery(CredentialRecoveryId $id): ?KeyMaker
    {
        return $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToCredentialRecoverySelectionSpec($id),
        );
    }

    /**
     * @param CredentialRecoveryId $id
     * @param string|null $msg
     * @return KeyMaker
     */
    public function findKeyMakerOfCredentialRecoveryOrNotFound(CredentialRecoveryId $id, string $msg = null): KeyMaker
    {
        $keyMaker = $this->findKeyMakerOfCredentialRecovery($id);
        if (null === $keyMaker) {
            throw new NotFoundException($msg ?? 'Key maker not found.');
        }

        return $keyMaker;
    }
}
