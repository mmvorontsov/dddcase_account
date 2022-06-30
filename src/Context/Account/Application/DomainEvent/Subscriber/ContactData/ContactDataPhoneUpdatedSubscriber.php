<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\ContactData;

use Exception;
use App\Context\Account\Application\Message\Internal\NotifySuccessfulPhoneChange\NotifySuccessfulPhoneChangeV1;
use App\Context\Account\Application\Message\Interservice\Account\{
    ContactDataPhoneUpdated\ContactDataPhoneUpdatedV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataPhoneUpdated;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Class ContactDataPhoneUpdatedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\ContactData
 */
final class ContactDataPhoneUpdatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * ContactDataPhoneUpdatedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param ContactDataPhoneUpdated $event
     * @throws Exception
     */
    public function __invoke(ContactDataPhoneUpdated $event)
    {
        $this->createInternalNotifySuccessfulPhoneChange($event);
        $this->createInterserviceContactDataPhoneUpdated($event);
    }

    /**
     * @param ContactDataPhoneUpdated $event
     * @throws Exception
     */
    private function createInternalNotifySuccessfulPhoneChange(ContactDataPhoneUpdated $event): void
    {
        $contactData = $event->getContactData();

        $recipients = [
            new SmsNotificationRecipient($event->getFromPhone()),
            new SmsNotificationRecipient($contactData->getPhone()->getValue()),
        ];

        foreach ($recipients as $recipient) {
            $this->outboxQueueManager->add(
                NotifySuccessfulPhoneChangeV1::create(
                    $recipient,
                    $contactData->getContactDataId()->getValue(),
                    $event->getFromPhone()->getValue(),
                    $contactData->getEmail()->getValue()
                )
            );
        }
    }

    /**
     * @param ContactDataPhoneUpdated $event
     * @throws Exception
     */
    private function createInterserviceContactDataPhoneUpdated(ContactDataPhoneUpdated $event): void
    {
        $contactData = $event->getContactData();

        $this->outboxQueueManager->add(
            ContactDataPhoneUpdatedV1::create(
                $contactData->getUserId()->getValue(),
                $contactData->getContactDataId()->getValue(),
                $event->getFromPhone()->getValue(),
                $contactData->getPhone()->getValue()
            )
        );
    }
}
