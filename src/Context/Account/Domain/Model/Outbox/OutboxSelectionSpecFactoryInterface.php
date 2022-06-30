<?php

namespace App\Context\Account\Domain\Model\Outbox;

/**
 * Interface OutboxSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\Outbox
 */
interface OutboxSelectionSpecFactoryInterface
{
    /**
     * @param int $limit
     * @return OutboxSelectionSpecInterface
     */
    public function createIsPrioritySelectionSpec(int $limit): OutboxSelectionSpecInterface;
}
