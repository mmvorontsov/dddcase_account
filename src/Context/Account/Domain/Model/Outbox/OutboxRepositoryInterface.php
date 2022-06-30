<?php

namespace App\Context\Account\Domain\Model\Outbox;

/**
 * Interface OutboxRepositoryInterface
 * @package App\Context\Account\Domain\Model\Outbox
 */
interface OutboxRepositoryInterface
{
    /**
     * @param Outbox $outbox
     */
    public function add(Outbox $outbox): void;

    /**
     * @param Outbox $outbox
     */
    public function remove(Outbox $outbox): void;

    /**
     * @param OutboxSelectionSpecInterface $spec
     * @return Outbox[]
     */
    public function selectSatisfying(OutboxSelectionSpecInterface $spec): array;
}
