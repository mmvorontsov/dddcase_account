<?php

namespace App\Context\Account\Domain\Service\SignCredentialRecovery;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\CredentialRecovery\Sign\CredentialRecoverySigned;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use Exception;

/**
 * Class SignCredentialRecoveryService
 * @package App\Context\Account\Domain\Service\SignCredentialRecovery
 */
final class SignCredentialRecoveryService implements SignCredentialRecoveryServiceInterface
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
     * SignCredentialRecoveryService constructor.
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
     * @param SignCredentialRecoveryCommand $command
     * @return CredentialRecovery
     * @throws Exception
     */
    public function execute(SignCredentialRecoveryCommand $command): CredentialRecovery
    {
        $credentialRecovery = $command->getCredentialRecovery();
        $credentialRecovery->sign();

        $keyMaker = $this->findCredentialRecoveryKeyMaker($credentialRecovery->getCredentialRecoveryId());
        $keyMaker->acceptLastSecretCode($command->getSecretCode());

        DomainEventSubject::instance()->notify(
            new CredentialRecoverySigned($credentialRecovery),
        );

        return $credentialRecovery;
    }

    /**
     * @param CredentialRecoveryId $id
     * @return CredentialRecoveryKeyMaker
     */
    private function findCredentialRecoveryKeyMaker(CredentialRecoveryId $id): CredentialRecoveryKeyMaker
    {
        /** @var CredentialRecoveryKeyMaker|null $credentialRecoveryKeyMaker */
        $credentialRecoveryKeyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToCredentialRecoverySelectionSpec($id),
        );

        if (null === $credentialRecoveryKeyMaker) {
            throw new DomainException('Credential recovery key maker not found.');
        }

        return $credentialRecoveryKeyMaker;
    }
}
