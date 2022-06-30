<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\ContactDataChange;

use Exception;
use App\Context\Account\Application\Message\Internal\ContactDataChangeSigned\ContactDataChangeSignedV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactDataChange\Sign\ContactDataChangeSigned;

/**
 * Class ContactDataChangeSignedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\ContactDataChange
 */
final class ContactDataChangeSignedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * ContactDataChangeSignedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param ContactDataChangeSigned $event
     * @throws Exception
     */
    public function __invoke(ContactDataChangeSigned $event)
    {
        $this->createInternalContactDataChangeSigned($event);
    }

    /**
     * @param ContactDataChangeSigned $event
     * @throws Exception
     */
    private function createInternalContactDataChangeSigned(ContactDataChangeSigned $event): void
    {
        $contactDataChange = $event->getContactDataChange();

        $this->outboxQueueManager->add(
            ContactDataChangeSignedV1::create(
                $contactDataChange->getContactDataChangeId()->getValue()
            )
        );
    }
}
