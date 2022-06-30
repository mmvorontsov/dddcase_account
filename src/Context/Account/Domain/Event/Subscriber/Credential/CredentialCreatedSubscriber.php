<?php

namespace App\Context\Account\Domain\Event\Subscriber\Credential;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\Credential\CredentialCreated;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecFactoryInterface;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class CredentialCreatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\Credential
 */
final class CredentialCreatedSubscriber implements DomainEventSubscriberInterface
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
     * CredentialCreatedSubscriber constructor.
     * @param CredentialRepositoryInterface $credentialRepository
     * @param CredentialSelectionSpecFactoryInterface $credentialSelectionSpecFactory
     */
    public function __construct(
        CredentialRepositoryInterface $credentialRepository,
        CredentialSelectionSpecFactoryInterface $credentialSelectionSpecFactory
    ) {
        $this->credentialRepository = $credentialRepository;
        $this->credentialSelectionSpecFactory = $credentialSelectionSpecFactory;
    }

    /**
     * @param CredentialCreated $event
     */
    public function __invoke(CredentialCreated $event): void
    {
        $this->checkCredentialUsernameUniqueness($event);
    }

    /**
     * @param CredentialCreated $event
     */
    private function checkCredentialUsernameUniqueness(CredentialCreated $event): void
    {
        $username = $event->getCredential()->getUsername();

        if (null === $username) {
            return;
        }

        $credential = $this->credentialRepository->selectOneSatisfying(
            $this->credentialSelectionSpecFactory->createHasUsernameSelectionSpec($username)
        );

        if (null !== $credential) {
            throw new UniqueViolationException(
                sprintf('Username %s is already in use.', $username)
            );
        }
    }
}
