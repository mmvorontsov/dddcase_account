<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\Credential;

use Exception;
use App\Context\Account\Application\Message\Internal\NotifySuccessfulPasswordChange\{
    NotifySuccessfulPasswordChangeV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Credential\Update\CredentialPasswordUpdated;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;
use UnexpectedValueException;

/**
 * Class CredentialPasswordUpdatedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\Credential
 */
final class CredentialPasswordUpdatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * @var ContactDataRepositoryInterface
     */
    private ContactDataRepositoryInterface $contactDataRepository;

    /**
     * @var ContactDataSelectionSpecFactoryInterface
     */
    private ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory;

    /**
     * CredentialPasswordUpdatedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     */
    public function __construct(
        OutboxQueueManagerInterface $outboxQueueManager,
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
    ) {
        $this->outboxQueueManager = $outboxQueueManager;
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
    }

    /**
     * @param CredentialPasswordUpdated $event
     * @throws Exception
     */
    public function __invoke(CredentialPasswordUpdated $event)
    {
        $this->createInternalNotifyCredentialPasswordUpdated($event);
    }

    /**
     * @param CredentialPasswordUpdated $event
     * @throws Exception
     */
    private function createInternalNotifyCredentialPasswordUpdated(CredentialPasswordUpdated $event): void
    {
        $credential = $event->getCredential();

        $contactDataSpec = $this->contactDataSelectionSpecFactory->createBelongsToUserSelectionSpec($credential->getUserId());
        $contactData = $this->contactDataRepository->selectOneSatisfying($contactDataSpec);

        if (null === $contactData) {
            return;
        }

        $recipients = $this->createNotificationRecipientsFromContactData($contactData);

        foreach ($recipients as $recipient) {
            $this->outboxQueueManager->add(
                NotifySuccessfulPasswordChangeV1::create(
                    $recipient,
                    $contactData->getContactDataId()->getValue()
                )
            );
        }
    }

    /**
     * @param ContactData $contactData
     * @return NotificationRecipient[]
     */
    private function createNotificationRecipientsFromContactData(ContactData $contactData): array
    {
        $recipients = [];

        if (null !== $contactData->getEmail()) {
            $recipients[] = new EmailNotificationRecipient($contactData->getEmail());
        }

        if (null !== $contactData->getPhone()) {
            $recipients[] = new SmsNotificationRecipient($contactData->getPhone());
        }

        if (empty($recipients)) {
            throw new UnexpectedValueException('Notification recipient must be specified.');
        }

        return $recipients;
    }
}
