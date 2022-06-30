<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialId;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class CredentialAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class CredentialAddition implements CredentialAdditionInterface
{
    /**
     * @var CredentialRepositoryInterface
     */
    private CredentialRepositoryInterface $credentialRepository;

    /**
     * @var CredentialSelectionSpecFactoryInterface
     */
    private CredentialSelectionSpecFactoryInterface $credentialSelectionSpecFactory;

    /**
     * CredentialAddition constructor.
     * @param CredentialRepositoryInterface $credentialRepository
     * @param CredentialSelectionSpecFactoryInterface $credentialSelectionSpecFactory
     */
    public function __construct(
        CredentialRepositoryInterface $credentialRepository,
        CredentialSelectionSpecFactoryInterface $credentialSelectionSpecFactory,
    ) {
        $this->credentialRepository = $credentialRepository;
        $this->credentialSelectionSpecFactory = $credentialSelectionSpecFactory;
    }

    /**
     * @param CredentialId $id
     * @return Credential|null
     */
    public function findById(CredentialId $id): ?Credential
    {
        return $this->credentialRepository->findById($id);
    }

    /**
     * @param CredentialId $id
     * @param string|null $msg
     * @return Credential
     */
    public function findByIdOrNotFound(CredentialId $id, string $msg = null): Credential
    {
        $credential = $this->findById($id);
        if (null === $credential) {
            throw new NotFoundException($msg ?? 'Credential data not found.');
        }

        return $credential;
    }

    /**
     * @param UserId $id
     * @return Credential|null
     */
    public function findCredentialOfUser(UserId $id): ?Credential
    {
        return $this->credentialRepository->selectOneSatisfying(
            $this->credentialSelectionSpecFactory->createBelongsToUserSelectionSpec($id),
        );
    }

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return Credential
     */
    public function findCredentialOfUserOrNotFound(UserId $id, string $msg = null): Credential
    {
        $credential = $this->findCredentialOfUser($id);
        if (null === $credential) {
            throw new NotFoundException($msg ?? 'Credential data not found.');
        }

        return $credential;
    }
}
