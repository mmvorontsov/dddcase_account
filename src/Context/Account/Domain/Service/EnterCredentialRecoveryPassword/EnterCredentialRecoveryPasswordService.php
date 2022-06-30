<?php

namespace App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Credential\Update\UpdateCredentialCommand;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\EnterPassword\CredentialRecoveryPasswordEntered;
use App\Context\Account\Domain\Model\User\UserId;
use Exception;

/**
 * Class EnterCredentialRecoveryPasswordService
 * @package App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordService implements EnterCredentialRecoveryPasswordServiceInterface
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
     * EnterCredentialRecoveryPasswordService constructor.
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
     * @param EnterCredentialRecoveryPasswordCommand $command
     * @return CredentialRecovery
     * @throws Exception
     */
    public function execute(EnterCredentialRecoveryPasswordCommand $command): CredentialRecovery
    {
        $credentialRecovery = $command->getCredentialRecovery();
        $credentialRecovery->enterPassword($command->getPasswordEntryCode());

        $credential = $this->findUserCredential($credentialRecovery->getUserId());
        $updateCommand = new UpdateCredentialCommand();
        $updateCommand->setHashedPassword($command->getHashedPassword());
        $credential->update($updateCommand);

        DomainEventSubject::instance()->notify(
            new CredentialRecoveryPasswordEntered($credentialRecovery),
        );

        return $credentialRecovery;
    }

    /**
     * @param UserId $userId
     * @return Credential
     */
    private function findUserCredential(UserId $userId): Credential
    {
        $credential = $this->credentialRepository->selectOneSatisfying(
            $this->credentialSelectionSpecFactory->createBelongsToUserSelectionSpec($userId),
        );

        if (null === $credential) {
            throw new DomainException('Credential not found.');
        }

        return $credential;
    }
}
