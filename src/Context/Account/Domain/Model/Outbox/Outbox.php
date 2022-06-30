<?php

namespace App\Context\Account\Domain\Model\Outbox;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Model\AggregateRootInterface;

/**
 * Class Outbox
 * @package App\Context\Account\Domain\Model\Outbox
 */
final class Outbox implements AggregateRootInterface
{
    /**
     * @var OutboxId
     */
    private OutboxId $outboxId;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * Outbox constructor.
     * @param OutboxId $outboxId
     * @param string $type
     * @param array $data
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(OutboxId $outboxId, string $type, array $data, DateTimeImmutable $createdAt)
    {
        $this->outboxId = $outboxId;
        $this->type = $type;
        $this->data = $data;
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $type
     * @param array $data
     * @return Outbox
     * @throws Exception
     */
    public static function create(string $type, array $data): Outbox
    {
        return new self(
            OutboxId::create(),
            $type,
            $data,
            new DateTimeImmutable(),
        );
    }

    /**
     * @return OutboxId
     */
    public function getOutboxId(): OutboxId
    {
        return $this->outboxId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
