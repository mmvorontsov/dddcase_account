<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\User;

use Exception;
use App\Context\Account\Application\Message\Interservice\Account\UserCreated\UserCreatedV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\User\UserCreated;

/**
 * Class UserCreatedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\User
 */
final class UserCreatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * UserCreatedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param UserCreated $event
     * @throws Exception
     */
    public function __invoke(UserCreated $event)
    {
        $this->createInterserviceUserCreated($event);
    }

    /**
     * @param UserCreated $event
     * @throws Exception
     */
    private function createInterserviceUserCreated(UserCreated $event): void
    {
        $user = $event->getUser();

        $this->outboxQueueManager->add(
            UserCreatedV1::create(
                $user->getUserId()->getValue()
            )
        );
    }
}
