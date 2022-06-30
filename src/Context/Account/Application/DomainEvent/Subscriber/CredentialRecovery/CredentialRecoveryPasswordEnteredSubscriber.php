<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\CredentialRecovery;

use Exception;
use App\Context\Account\Application\Message\Internal\CredentialRecoveryPasswordEntered\{
    CredentialRecoveryPasswordEnteredV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\CredentialRecovery\EnterPassword\CredentialRecoveryPasswordEntered;

/**
 * Class CredentialRecoveryPasswordEnteredSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\CredentialRecovery
 */
final class CredentialRecoveryPasswordEnteredSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * CredentialRecoveryPasswordEnteredSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param CredentialRecoveryPasswordEntered $event
     * @throws Exception
     */
    public function __invoke(CredentialRecoveryPasswordEntered $event)
    {
        $this->createInternalCredentialRecoveryPasswordEntered($event);
    }

    /**
     * @param CredentialRecoveryPasswordEntered $event
     * @throws Exception
     */
    private function createInternalCredentialRecoveryPasswordEntered(CredentialRecoveryPasswordEntered $event): void
    {
        $credentialRecovery = $event->getCredentialRecovery();

        $this->outboxQueueManager->add(
            CredentialRecoveryPasswordEnteredV1::create(
                $credentialRecovery->getCredentialRecoveryId()->getValue(),
            ),
        );
    }
}
