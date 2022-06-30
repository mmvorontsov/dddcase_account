<?php

namespace App\Context\Account\Application\Message;

use App\Context\Account\Domain\Model\Inbox\Inbox;
use App\Context\Account\Infrastructure\Messaging\Message\MessageInterface;

/**
 * Interface InboxHistoryManagerInterface
 * @package App\Context\Account\Application\Message
 */
interface InboxHistoryManagerInterface
{
    /**
     * @param MessageInterface $message
     * @param float $processingTime
     * @return Inbox
     */
    public function add(MessageInterface $message, float $processingTime): Inbox;

    /**
     * @param MessageInterface $message
     * @return bool
     */
    public function isProcessed(MessageInterface $message): bool;
}
