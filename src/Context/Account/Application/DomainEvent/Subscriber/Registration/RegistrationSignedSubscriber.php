<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\Registration;

use Exception;
use App\Context\Account\Application\Message\Internal\RegistrationSigned\RegistrationSignedV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\Registration\Sign\RegistrationSigned;

/**
 * Class RegistrationSignedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\Registration
 */
final class RegistrationSignedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * RegistrationSignedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param RegistrationSigned $event
     * @throws Exception
     */
    public function __invoke(RegistrationSigned $event)
    {
        $this->createInternalRegistrationSigned($event);
    }

    /**
     * @param RegistrationSigned $event
     * @throws Exception
     */
    private function createInternalRegistrationSigned(RegistrationSigned $event): void
    {
        $registration = $event->getRegistration();

        $this->outboxQueueManager->add(
            RegistrationSignedV1::create(
                $registration->getRegistrationId()->getValue()
            )
        );
    }
}
