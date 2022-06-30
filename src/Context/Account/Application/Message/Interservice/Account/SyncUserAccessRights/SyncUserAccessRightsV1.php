<?php

namespace App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights;

use DateTimeImmutable;
use Exception;
use App\Context\Account\AccountContext;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;

/**
 * Class SyncUserAccessRightsV1
 * @package App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights
 */
final class SyncUserAccessRightsV1 extends AbstractCommand implements
    InterserviceCommandInterface,
    RoutableMessageInterface
{
    public const ROUTING_KEY = 'dddcase_account.sync_user_access_rights.v1';

    /**
     * Value example:
     * [
     *     'PERMISSION__DDDCASE_ACCOUNT__USER_UPDATE' => [
     *         'description' => 'Update user',
     *         'roles' => [
     *             'ROLE__USER__DDDCASE_ACCOUNT__ADMIN',
     *             'ROLE_PROTECTED__USER',
     *             'ROLE_PROTECTED__USER__ADMIN',
     *             'ROLE_PROTECTED__USER__SUPER_ADMIN',
     *         ]
     *     ],
     *     'PERMISSION__DDDCASE_ACCOUNT__USER_DELETE' => [
     *         ...
     *     ]
     * ]
     * @var array
     */
    private array $userAccessRights;

    /**
     * @var string
     */
    private string $contextId;

    /**
     * @var string
     */
    private string $replyRecipientContextId;

    /**
     * SyncUserAccessRightsV1 constructor.
     * @param string $messageId
     * @param array $userAccessRights
     * @param string $replyRecipientContextId
     * @param string $contextId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        array $userAccessRights,
        string $replyRecipientContextId,
        string $contextId,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->userAccessRights = $userAccessRights;
        $this->contextId = $contextId;
        $this->replyRecipientContextId = $replyRecipientContextId;
    }

    /**
     * @param array $userAccessRights
     * @return static
     * @throws Exception
     */
    public static function create(array $userAccessRights): self
    {
        return new self(
            Uuid::create(),
            $userAccessRights,
            AccountContext::CONTEXT_ID,
            AccountContext::CONTEXT_ID,
            new DateTimeImmutable()
        );
    }

    /**
     * @return array
     */
    public function getUserAccessRights(): array
    {
        return $this->userAccessRights;
    }

    /**
     * @return string
     */
    public function getContextId(): string
    {
        return $this->contextId;
    }

    /**
     * @return string
     */
    public function getReplyRecipientContextId(): string
    {
        return $this->replyRecipientContextId;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return self::ROUTING_KEY;
    }
}
