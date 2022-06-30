<?php

namespace App\Context\Account\Infrastructure\Notification\Assistant;

/**
 * Interface SmsAssistantInterface
 * @package App\Context\Account\Infrastructure\Notification\Assistant
 */
interface SmsAssistantInterface
{
    /**
     * @param object $notification
     * @param object $recipient
     * @return array
     */
    public function createContext(object $notification, object $recipient): array;

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
     * @param string $message
     * @param string $phone
     */
    public function send(string $message, string $phone): void;
}
