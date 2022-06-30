<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine;

use App\Context\Account\Domain\Model\Outbox\OutboxSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Outbox\OutboxSelectionSpecInterface;

/**
 * Class DoctrineOutboxSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine
 */
final class DoctrineOutboxSelectionSpecFactory implements OutboxSelectionSpecFactoryInterface
{
    /**
     * @param int $limit
     * @return OutboxSelectionSpecInterface
     */
    public function createIsPrioritySelectionSpec(int $limit): OutboxSelectionSpecInterface
    {
        return new DoctrineIsPrioritySelectionSpec($limit);
    }
}
