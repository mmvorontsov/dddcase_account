<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification;

use App\Context\Account\Infrastructure\Notification\Assistant\SmsAssistantInterface;
use App\Context\Account\Infrastructure\Notification\NotificationInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Class AbstractSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification
 */
abstract class AbstractSmsSender
{
    /**
     * @var SmsAssistantInterface
     */
    private SmsAssistantInterface $smsAssistant;

    /**
     * AbstractSmsSender constructor.
     * @param SmsAssistantInterface $smsAssistant
     */
    public function __construct(SmsAssistantInterface $smsAssistant)
    {
        $this->smsAssistant = $smsAssistant;
    }

    /**
     * @return string
     */
    abstract protected function getTemplatePath(): string;

    /**
     * @param NotificationInterface $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function sendSms(NotificationInterface $notification, SmsNotificationRecipient $recipient): void
    {
        $context = $this->smsAssistant->createContext($notification, $recipient);
        $message = $this->smsAssistant->render($this->getTemplatePath(), $context);
        $this->smsAssistant->send($message, $recipient->getPhone());
    }

    /**
     * @param NotificationInterface $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderSmsPreview(NotificationInterface $notification, SmsNotificationRecipient $recipient): string
    {
        $context = $this->smsAssistant->createPreviewContext($notification, $recipient);

        return $this->smsAssistant->render($this->getTemplatePath(), $context);
    }
}
