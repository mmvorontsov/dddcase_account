<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\KeyMaker;

use Exception;
use InvalidArgumentException;
use App\Context\Account\Application\Message\Internal\{
    NotifyContactDataChangeSecretCode\NotifyContactDataChangeSecretCodeV1,
    NotifyCredentialRecoverySecretCode\NotifyCredentialRecoverySecretCodeV1,
    NotifyRegistrationSecretCode\NotifyRegistrationSecretCodeV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\Recipient;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSecretCodeAdded;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;
use UnexpectedValueException;

use function sprintf;

/**
 * Class KeyMakerSecretCodeAddedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\KeyMaker
 */
final class KeyMakerSecretCodeAddedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * KeyMakerSecretCodeAddedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param KeyMakerSecretCodeAdded $event
     * @throws Exception
     */
    public function __invoke(KeyMakerSecretCodeAdded $event): void
    {
        $this->createInternalNotifySecretCode($event);
    }

    /**
     * @param KeyMakerSecretCodeAdded $event
     * @throws Exception
     */
    private function createInternalNotifySecretCode(KeyMakerSecretCodeAdded $event): void
    {
        $keyMaker = $event->getKeyMaker();

        if ($keyMaker->getIsMute()) {
            return;
        }

        switch (true) {
            case $keyMaker instanceof RegistrationKeyMaker:
                $this->createInternalNotifyRegistrationSecretCode($event);
                return;
            case $keyMaker instanceof ContactDataChangeKeyMaker:
                $this->createInternalNotifyContactDataChangeSecretCode($event);
                return;
            case $keyMaker instanceof CredentialRecoveryKeyMaker:
                $this->createInternalNotifyCredentialRecoverySecretCode($event);
                return;
        }

        throw new UnexpectedValueException(
            sprintf('Unexpected key maker type %s.', $keyMaker::class),
        );
    }

    /**
     * @param KeyMakerSecretCodeAdded $event
     * @throws Exception
     */
    private function createInternalNotifyRegistrationSecretCode(KeyMakerSecretCodeAdded $event): void
    {
        /** @var RegistrationKeyMaker $keyMaker */
        $keyMaker = $event->getKeyMaker();

        $this->outboxQueueManager->add(
            NotifyRegistrationSecretCodeV1::create(
                $this->createNotificationRecipientFromRecipient($keyMaker->getRecipient()),
                $keyMaker->getRegistrationId()->getValue(),
                $event->getSecretCode()->getCode(),
            ),
        );
    }

    /**
     * @param KeyMakerSecretCodeAdded $event
     * @throws Exception
     */
    private function createInternalNotifyContactDataChangeSecretCode(KeyMakerSecretCodeAdded $event): void
    {
        /** @var ContactDataChangeKeyMaker $keyMaker */
        $keyMaker = $event->getKeyMaker();

        $this->outboxQueueManager->add(
            NotifyContactDataChangeSecretCodeV1::create(
                $this->createNotificationRecipientFromRecipient($keyMaker->getRecipient()),
                $keyMaker->getContactDataChangeId()->getValue(),
                $event->getSecretCode()->getCode(),
            ),
        );
    }

    /**
     * @param KeyMakerSecretCodeAdded $event
     * @throws Exception
     */
    private function createInternalNotifyCredentialRecoverySecretCode(KeyMakerSecretCodeAdded $event): void
    {
        /** @var CredentialRecoveryKeyMaker $keyMaker */
        $keyMaker = $event->getKeyMaker();

        $this->outboxQueueManager->add(
            NotifyCredentialRecoverySecretCodeV1::create(
                $this->createNotificationRecipientFromRecipient($keyMaker->getRecipient()),
                $keyMaker->getCredentialRecoveryId()->getValue(),
                $event->getSecretCode()->getCode(),
            ),
        );
    }

    /**
     * @param Recipient $recipient
     * @return NotificationRecipient
     */
    private function createNotificationRecipientFromRecipient(Recipient $recipient): NotificationRecipient
    {
        $primaryContactData = $recipient->getPrimaryContactData();

        return match (true) {
            $primaryContactData instanceof EmailAddress => new EmailNotificationRecipient(
                $primaryContactData->getValue(),
            ),
            $primaryContactData instanceof PhoneNumber => new SmsNotificationRecipient(
                $primaryContactData->getValue(),
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected primary contact data type %s.', $primaryContactData::class),
            ),
        };
    }
}
