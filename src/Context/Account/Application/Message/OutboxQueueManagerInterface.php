<?php

namespace App\Context\Account\Application\Message;

use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Infrastructure\Messaging\Message\MessageInterface;

/**
 * Interface OutboxQueueManagerInterface
 * @package App\Context\Account\Application\Message
 */
interface OutboxQueueManagerInterface
{
    /**
     * @param MessageInterface $message
     * @return Outbox
     */
    public function add(MessageInterface $message): Outbox;
}
