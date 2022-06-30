<?php

namespace App\Context\Account\Application\Message\Internal\RoleRemoved;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;

/**
 * Class RoleRemovedV1
 * @package App\Context\Account\Application\Message\Internal\RoleRemoved
 */
final class RoleRemovedV1 extends AbstractEvent implements InternalEventInterface
{
    /**
     * @var string
     */
    private string $roleId;

    /**
     * RoleRemovedV1 constructor.
     * @param string $messageId
     * @param string $roleId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, string $roleId, DateTimeImmutable $occurredOn)
    {
        parent::__construct($messageId, $occurredOn);
        $this->roleId = $roleId;
    }

    /**
     * @param string $roleId
     * @return static
     * @throws Exception
     */
    public static function create(string $roleId): self
    {
        return new self(
            Uuid::create(),
            $roleId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->roleId;
    }
}
