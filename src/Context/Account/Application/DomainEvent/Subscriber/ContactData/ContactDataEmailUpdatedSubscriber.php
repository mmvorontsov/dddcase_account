<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\ContactData;

use Exception;
use App\Context\Account\Application\Message\Internal\NotifySuccessfulEmailChange\NotifySuccessfulEmailChangeV1;
use App\Context\Account\Application\Message\Interservice\Account\ContactDataEmailUpdated\{
    ContactDataEmailUpdatedV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataEmailUpdated;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;

/**
 * Class ContactDataEmailUpdatedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\ContactData
 */
final class ContactDataEmailUpdatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * ContactDataEmailUpdatedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param ContactDataEmailUpdated $event
     * @throws Exception
     */
    public function __invoke(ContactDataEmailUpdated $event)
    {
        $this->createInternalNotifySuccessfulEmailChange($event);
        $this->createInterserviceContactDataEmailUpdated($event);
    }

    /**
     * @param ContactDataEmailUpdated $event
     * @throws Exception
     */
    private function createInternalNotifySuccessfulEmailChange(ContactDataEmailUpdated $event): void
    {
        $contactData = $event->getContactData();

        $recipients = [
            new EmailNotificationRecipient($event->getFromEmail()),
            new EmailNotificationRecipient($contactData->getEmail()->getValue()),
        ];

        foreach ($recipients as $recipient) {
            $this->outboxQueueManager->add(
                NotifySuccessfulEmailChangeV1::create(
                    $recipient,
                    $contactData->getContactDataId()->getValue(),
                    $event->getFromEmail()->getValue(),
                    $contactData->getEmail()->getValue()
                )
            );
        }
    }

    /**
     * @param ContactDataEmailUpdated $event
     * @throws Exception
     */
    private function createInterserviceContactDataEmailUpdated(ContactDataEmailUpdated $event): void
    {
        $contactData = $event->getContactData();

        $this->outboxQueueManager->add(
            ContactDataEmailUpdatedV1::create(
                $contactData->getUserId()->getValue(),
                $contactData->getContactDataId()->getValue(),
                $event->getFromEmail()->getValue(),
                $contactData->getEmail()->getValue()
            )
        );
    }
}
