<?php

namespace App\Context\Account\Application\Message\Internal\RemoveUserRole;

use DateTimeImmutable;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;

/**
 * Class RemoveUserRoleV1
 * @package App\Context\Account\Application\Message\Internal\RemoveUserRole
 */
final class RemoveUserRoleV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var string
     */
    private string $userId;

    /**
     * @var string
     */
    private string $roleId;

    /**
     * RemoveUserRoleV1 constructor.
     * @param string $messageId
     * @param string $userId
     * @param string $roleId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(string $messageId, string $userId, string $roleId, DateTimeImmutable $createdAt)
    {
        parent::__construct($messageId, $createdAt);
        $this->userId = $userId;
        $this->roleId = $roleId;
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
    public function getRoleId(): string
    {
        return $this->roleId;
    }
}
