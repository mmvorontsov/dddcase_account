<?php

namespace App\Context\Account\Domain\Model\Inbox;

use DateTimeImmutable;
use App\Context\Account\Domain\Model\AggregateRootInterface;

use function round;

/**
 * Class Inbox
 * @package App\Context\Account\Domain\Model\Inbox
 */
final class Inbox implements AggregateRootInterface
{
    /**
     * @var InboxId
     */
    private InboxId $inboxId;

    /**
     * @var string
     */
    private string $messageName;

    /**
     * @var float
     */
    private float $processingTime;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * Inbox constructor.
     * @param InboxId $inboxId
     * @param string $messageName
     * @param float $processingTime
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        InboxId $inboxId,
        string $messageName,
        float $processingTime,
        DateTimeImmutable $createdAt
    ) {
        $this->inboxId = $inboxId;
        $this->messageName = $messageName;
        $this->processingTime = $processingTime;
        $this->createdAt = $createdAt;
    }

    /**
     * @param InboxId $inboxId
     * @param string $messageName
     * @param float $processingTime
     * @return Inbox
     */
    public static function create(InboxId $inboxId, string $messageName, float $processingTime): Inbox
    {
        return new self(
            $inboxId,
            $messageName,
            round($processingTime, 3),
            new DateTimeImmutable()
        );
    }

    /**
     * @return InboxId
     */
    public function getInboxId(): InboxId
    {
        return $this->inboxId;
    }

    /**
     * @return string
     */
    public function getMessageName(): string
    {
        return $this->messageName;
    }

    /**
     * @return float
     */
    public function getProcessingTime(): float
    {
        return $this->processingTime;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
