<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification;

use App\Context\Account\Infrastructure\Notification\{
    Assistant\EmailAssistantInterface,
    NotificationInterface as Notification,
    Recipient\EmailNotificationRecipient as EmailRecipient,
};
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * Class AbstractEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification
 */
abstract class AbstractEmailSender
{
    /**
     * @var EmailAssistantInterface
     */
    private EmailAssistantInterface $emailAssistant;

    /**
     * AbstractEmailSender constructor.
     * @param EmailAssistantInterface $emailAssistant
     */
    public function __construct(EmailAssistantInterface $emailAssistant)
    {
        $this->emailAssistant = $emailAssistant;
    }

    /**
     * @return string
     */
    abstract protected function getTemplatePath(): string;

    /**
     * @param Notification $notification
     * @param EmailRecipient $recipient
     * @param string $subject
     */
    protected function sendEmail(Notification $notification, EmailRecipient $recipient, string $subject): void
    {
        $email = (new Email())
            ->from(
                new Address(
                    $this->emailAssistant->getSenderEmail(),
                    $this->emailAssistant->getSenderName(),
                ),
            )
            ->to(new Address($recipient->getEmail()))
            ->subject($subject);

        $context = $this->emailAssistant->createContext($notification, $recipient, $email);
        $email->html($this->emailAssistant->render($this->getTemplatePath(), $context));
        $this->emailAssistant->send($email);
    }

    /**
     * @param Notification $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    protected function renderEmailPreview(Notification $notification, EmailRecipient $recipient): string
    {
        $context = $this->emailAssistant->createPreviewContext($notification, $recipient);

        return $this->emailAssistant->render($this->getTemplatePath(), $context);
    }
}
