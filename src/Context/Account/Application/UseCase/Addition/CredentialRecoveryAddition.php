<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryRepositoryInterface;

/**
 * Class CredentialRecoveryAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class CredentialRecoveryAddition implements CredentialRecoveryAdditionInterface
{
    /**
     * @var CredentialRecoveryRepositoryInterface
     */
    private CredentialRecoveryRepositoryInterface $credentialRecoveryRepository;

    /**
     * CredentialRecoveryAddition constructor.
     * @param CredentialRecoveryRepositoryInterface $credentialRecoveryRepository
     */
    public function __construct(CredentialRecoveryRepositoryInterface $credentialRecoveryRepository)
    {
        $this->credentialRecoveryRepository = $credentialRecoveryRepository;
    }

    /**
     * @param CredentialRecoveryId $id
     * @return CredentialRecovery|null
     */
    public function findById(CredentialRecoveryId $id): ?CredentialRecovery
    {
        return $this->credentialRecoveryRepository->findById($id);
    }

    /**
     * @param CredentialRecoveryId $id
     * @param string|null $msg
     * @return CredentialRecovery
     */
    public function findByIdOrNotFound(CredentialRecoveryId $id, string $msg = null): CredentialRecovery
    {
        $credentialRecovery = $this->findById($id);
        if (null === $credentialRecovery) {
            throw new NotFoundException($msg ?? 'Credential recovery data not found.');
        }

        return $credentialRecovery;
    }
}
