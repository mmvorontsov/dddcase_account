<?php

namespace App\Context\Account\Application\DomainEvent\Subscriber\Role;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\Internal\RoleRemoved\RoleRemovedV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\Role\Remove\RoleRemoved;

/**
 * Class RoleRemovedSubscriber
 * @package App\Context\Account\Application\DomainEvent\Subscriber\Role
 */
final class RoleRemovedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * RoleRemovedSubscriber constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     */
    public function __construct(OutboxQueueManagerInterface $outboxQueueManager)
    {
        $this->outboxQueueManager = $outboxQueueManager;
    }

    /**
     * @param RoleRemoved $event
     * @throws Exception
     */
    public function __invoke(RoleRemoved $event)
    {
        $this->createInternalRoleRemoved($event);
    }

    /**
     * @param RoleRemoved $event
     * @throws Exception
     */
    private function createInternalRoleRemoved(RoleRemoved $event): void
    {
        $role = $event->getRole();

        $this->outboxQueueManager->add(
            RoleRemovedV1::create(
                $role->getRoleId()->getValue()
            )
        );
    }
}
