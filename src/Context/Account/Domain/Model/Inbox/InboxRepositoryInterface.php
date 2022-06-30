<?php

namespace App\Context\Account\Domain\Model\Inbox;

/**
 * Interface InboxRepositoryInterface
 * @package App\Context\Account\Domain\Model\Inbox
 */
interface InboxRepositoryInterface
{
    /**
     * @param InboxId $inboxId
     * @return bool
     */
    public function containsId(InboxId $inboxId): bool;

    /**
     * @param Inbox $inbox
     */
    public function add(Inbox $inbox): void;

    /**
     * @param Inbox $inbox
     */
    public function remove(Inbox $inbox): void;

    /**
     * @param InboxSelectionSpecInterface $spec
     * @return Inbox[]
     */
    public function selectSatisfying(InboxSelectionSpecInterface $spec): array;
}
