<?php

namespace App\Context\Account\Domain\Event\Subscriber\Credential;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Credential\Update\CredentialUsernameUpdated;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class CredentialUsernameUpdatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\Credential
 */
final class CredentialUsernameUpdatedSubscriber implements DomainEventSubscriberInterface
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
     * @param CredentialUsernameUpdated $event
     */
    public function __invoke(CredentialUsernameUpdated $event): void
    {
        $this->checkCredentialUsernameUniqueness($event);
    }

    /**
     * @param CredentialUsernameUpdated $event
     */
    private function checkCredentialUsernameUniqueness(CredentialUsernameUpdated $event): void
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
