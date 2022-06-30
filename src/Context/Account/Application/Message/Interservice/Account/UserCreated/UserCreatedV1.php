<?php

namespace App\Context\Account\Application\Message\Interservice\Account\UserCreated;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;

/**
 * Class UserCreatedV1
 * @package App\Context\Account\Application\Message\Interservice\Account\UserCreated
 */
final class UserCreatedV1 extends AbstractEvent implements
    InterserviceEventInterface,
    RoutableMessageInterface
{
    public const ROUTING_KEY = 'dddcase_account.user_created.v1';

    /**
     * @var string
     */
    private string $userId;

    /**
     * UserCreatedV1 constructor.
     * @param string $messageId
     * @param string $userId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, string $userId, DateTimeImmutable $occurredOn)
    {
        parent::__construct($messageId, $occurredOn);
        $this->userId = $userId;
    }

    /**
     * @param string $userId
     * @return static
     * @throws Exception
     */
    public static function create(string $userId): self
    {
        return new self(
            Uuid::create(),
            $userId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return self::ROUTING_KEY;
    }
}
