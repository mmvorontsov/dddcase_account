<?php

namespace App\Context\Account\Infrastructure\Notification\Assistant;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

/**
 * Interface EmailAssistantInterface
 * @package App\Context\Account\Infrastructure\Notification\Assistant
 */
interface EmailAssistantInterface
{
    /**
     * @param object $notification
     * @param object $recipient
     * @param Email $email
     * @return array
     */
    public function createContext(object $notification, object $recipient, Email $email): array;

    /**
     * @param object $notification
     * @param object $recipient
     * @return array
     */
    public function createPreviewContext(object $notification, object $recipient): array;

    /**
     * @param $template
     * @param array $context
     * @return string
     */
    public function render($template, array $context = []): string;

    /**
     * @param RawMessage $message
     * @param Envelope|null $envelope
     */
    public function send(RawMessage $message, Envelope $envelope = null): void;

    /**
     * @return string
     */
    public function getSenderEmail(): string;

    /**
     * @return string
     */
    public function getSenderName(): string;
}
