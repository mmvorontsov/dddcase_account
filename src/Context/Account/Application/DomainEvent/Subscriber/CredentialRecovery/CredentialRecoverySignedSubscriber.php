<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\CredentialRecovery;

use Exception;
use App\Context\Account\Application\Message\Internal\CredentialRecoverySigned\CredentialRecoverySignedV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\CredentialRecovery\Sign\CredentialRecoverySigned;

/**
 * Class CredentialRecoverySignedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\CredentialRecovery
 */
final class CredentialRecoverySignedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * CredentialRecoverySignedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param CredentialRecoverySigned $event
     * @throws Exception
     */
    public function __invoke(CredentialRecoverySigned $event)
    {
        $this->createInternalCredentialRecoverySigned($event);
    }

    /**
     * @param CredentialRecoverySigned $event
     * @throws Exception
     */
    private function createInternalCredentialRecoverySigned(CredentialRecoverySigned $event): void
    {
        $credentialRecovery = $event->getCredentialRecovery();

        $this->outboxQueueManager->add(
            CredentialRecoverySignedV1::create(
                $credentialRecovery->getCredentialRecoveryId()->getValue(),
            ),
        );
    }
}
