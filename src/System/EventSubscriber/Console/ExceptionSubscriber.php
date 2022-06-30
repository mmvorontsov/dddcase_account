<?php

namespace App\System\EventSubscriber\Console;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use function get_class;
use function sprintf;

/**
 * Class ExceptionSubscriber
 * @package App\System\EventSubscriber\Console
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ExceptionSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::ERROR => [
                ['handleException'],
            ],
        ];
    }

    /**
     * @param ConsoleErrorEvent $event
     */
    public function handleException(ConsoleErrorEvent $event): void
    {
        $command = $event->getCommand();
        $exception = $event->getError();

        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s while running console command `%s`',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $command?->getName()
        );

        $this->logger->error($message);
    }
}
