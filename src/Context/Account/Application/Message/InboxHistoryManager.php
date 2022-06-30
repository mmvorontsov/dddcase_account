<?php

namespace App\Context\Account\Application\Message;

use App\Context\Account\Application\Message\Interservice\InterserviceMessageNameConverterInterface;
use App\Context\Account\Domain\Model\Inbox\Inbox;
use App\Context\Account\Domain\Model\Inbox\InboxId;
use App\Context\Account\Domain\Model\Inbox\InboxRepositoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceMessageInterface;
use App\Context\Account\Infrastructure\Messaging\Message\MessageInterface;
use ReflectionClass;

use function preg_match;

/**
 * Class InboxHistoryManager
 * @package App\Context\Account\Application\Message
 */
final class InboxHistoryManager implements InboxHistoryManagerInterface
{
    /**
     * @var InboxRepositoryInterface
     */
    private InboxRepositoryInterface $inboxRepository;

    /**
     * @var InterserviceMessageNameConverterInterface
     */
    private InterserviceMessageNameConverterInterface $interserviceMessageNameConverter;

    /**
     * InboxHistoryManager constructor.
     * @param InboxRepositoryInterface $inboxRepository
     * @param InterserviceMessageNameConverterInterface $interserviceMessageNameConverter
     */
    public function __construct(
        InboxRepositoryInterface $inboxRepository,
        InterserviceMessageNameConverterInterface $interserviceMessageNameConverter
    ) {
        $this->inboxRepository = $inboxRepository;
        $this->interserviceMessageNameConverter = $interserviceMessageNameConverter;
    }

    /**
     * @param MessageInterface $message
     * @param float $processingTime
     * @return Inbox
     */
    public function add(MessageInterface $message, float $processingTime): Inbox
    {
        $inboxId = InboxId::createFrom($message->getMessageId());

        $messageName = ($message instanceof InterserviceMessageInterface)
            ? $this->getInterserviceMessageName($message)
            : $this->getInternalMessageName($message);

        $inbox = Inbox::create($inboxId, $messageName, $processingTime);
        $this->inboxRepository->add($inbox);

        return $inbox;
    }

    /**
     * @param MessageInterface $message
     * @return bool
     */
    public function isProcessed(MessageInterface $message): bool
    {
        $inboxId = InboxId::createFrom($message->getMessageId());

        return $this->inboxRepository->containsId($inboxId);
    }

    /**
     * @param MessageInterface $message
     * @return string
     */
    private function getInterserviceMessageName(MessageInterface $message): string
    {
        return $this->interserviceMessageNameConverter->normalize($message::class);
    }

    /**
     * @param MessageInterface $message
     * @return string
     */
    private function getInternalMessageName(MessageInterface $message): string
    {
        $reflection = new ReflectionClass($message);
        $name = $reflection->getName();

        preg_match("/.*\\\\(\w+)\\\\(\w+)(V\d+)$/", $name, $matches);

        $name = $matches[1] ?? '';
        $version = $matches[3] ?? '';

        return strtolower("$name.$version");
    }
}
