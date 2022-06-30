<?php

namespace App\Context\Account\Infrastructure\Notification\Assistant;

use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Twig\Environment as Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SmsAssistant
 * @package App\Context\Account\Infrastructure\Notification\Assistant
 */
final class SmsAssistant implements SmsAssistantInterface
{
    /**
     * @var Twig
     */
    protected Twig $twig;

    /**
     * @var TexterInterface
     */
    private TexterInterface $texter;

    /**
     * SmsAssistant constructor.
     * @param Twig $twig
     * @param TexterInterface $texter
     */
    public function __construct(Twig $twig, TexterInterface $texter)
    {
        $this->twig = $twig;
        $this->texter = $texter;
    }

    /**
     * @param object $notification
     * @param object $recipient
     * @return object[]
     */
    public function createContext(object $notification, object $recipient): array
    {
        return [
            'notification' => $notification,
            'recipient' => $recipient,
        ];
    }

    /**
     * @param object $notification
     * @param object $recipient
     * @return object[]
     */
    public function createPreviewContext(object $notification, object $recipient): array
    {
        return [
            'notification' => $notification,
            'recipient' => $recipient,
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
     * @param string $message
     * @param string $phone
     * @throws TransportExceptionInterface
     */
    public function send(string $message, string $phone): void
    {
        $this->texter->send(new SmsMessage($phone, $message));
    }
}
