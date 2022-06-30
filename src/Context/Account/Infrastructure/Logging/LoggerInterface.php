<?php

namespace App\Context\Account\Infrastructure\Logging;

/**
 * Interface LoggerInterface
 * @package App\Context\Account\Infrastructure\Logging
 */
interface LoggerInterface
{
    /**
     * @param $message
     * @param array $context
     */
    public function error($message, array $context = []): void;

    /**
     * @param $message
     * @param array $context
     */
    public function warning($message, array $context = []): void;
}
