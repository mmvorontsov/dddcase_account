<?php

namespace App\Context\Account\Application\Message;

use Exception;
use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Domain\Model\Outbox\OutboxRepositoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\MessageInterface;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class OutboxQueueManager
 * @package App\Context\Account\Application\Message
 */
final class OutboxQueueManager implements OutboxQueueManagerInterface
{
    /**
     * @var OutboxRepositoryInterface
     */
    private OutboxRepositoryInterface $outboxRepository;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * OutboxQueueManager constructor.
     * @param OutboxRepositoryInterface $outboxRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(OutboxRepositoryInterface $outboxRepository, SerializerInterface $serializer)
    {
        $this->outboxRepository = $outboxRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param MessageInterface $message
     * @return Outbox
     * @throws Exception
     */
    public function add(MessageInterface $message): Outbox
    {
        $data = $this->serializer->normalize($message);

        $outbox = Outbox::create($message::class, $data);
        $this->outboxRepository->add($outbox);

        return $outbox;
    }
}
