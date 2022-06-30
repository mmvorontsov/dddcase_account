<?php

namespace App\Context\Account\Infrastructure\Notification\Assistant;

use App\Context\Account\Infrastructure\Templating\Twig\Context\Email\EmailContext;
use App\Context\Account\Infrastructure\Templating\Twig\Context\Email\EmailPreviewContext;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;
use Twig\Environment as Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class EmailAssistant
 * @package App\Context\Account\Infrastructure\Notification\Assistant
 */
final class EmailAssistant implements EmailAssistantInterface
{
    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var string
     */
    private string $senderEmail;

    /**
     * @var string
     */
    private string $senderName;

    /**
     * EmailAssistant constructor.
     * @param Twig $twig
     * @param MailerInterface $mailer
     * @param string $senderEmail
     * @param string $senderName
     */
    public function __construct(Twig $twig, MailerInterface $mailer, string $senderEmail, string $senderName)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
    }

    /**
     * @param object $notification
     * @param object $recipient
     * @param Email $email
     * @return array
     */
    public function createContext(object $notification, object $recipient, Email $email): array
    {
        return [
            'notification' => $notification,
            'recipient' => $recipient,
            'context' => new EmailContext($this->twig, $email),
        ];
    }

    /**
     * @param object $notification
     * @param object $recipient
     * @return array
     */
    public function createPreviewContext(object $notification, object $recipient): array
    {
        return [
            'notification' => $notification,
            'recipient' => $recipient,
            'context' => new EmailPreviewContext($this->twig),
        ];
    }

    /**
     * @param $template
     * @param array $context
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }

    /**
     * @param RawMessage $message
     * @param Envelope|null $envelope
     * @throws TransportExceptionInterface
     */
    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        $this->mailer->send($message, $envelope);
    }

    /**
     * @return string
     */
    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }
}
