<?php

namespace App\Context\Account\Infrastructure\Logging;

use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * Class Logger
 * @package App\Context\Account\Infrastructure\Logging
 */
final class Logger implements LoggerInterface
{
    /**
     * @var PsrLoggerInterface
     */
    private PsrLoggerInterface $logger;

    /**
     * Logger constructor.
     * @param PsrLoggerInterface $logger
     */
    public function __construct(PsrLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function error($message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function warning($message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }
}
