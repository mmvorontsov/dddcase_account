<?php

namespace App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\Reply;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractReply;
use App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\SyncUserAccessRightsV1;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceReplyInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;

/**
 * Class SyncUserAccessRightsV1Reply
 * @package App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\Reply
 */
final class SyncUserAccessRightsV1Reply extends AbstractReply implements
    InterserviceReplyInterface,
    RoutableMessageInterface
{
    public const ROUTING_KEY = 'reply_of:dddcase_account.sync_user_access_rights.v1';

    /**
     * @var SyncUserAccessRightsV1
     */
    private SyncUserAccessRightsV1 $target;

    /**
     * @var string
     */
    private string $recipientContextId;

    /**
     * @var bool
     */
    private bool $success;

    /**
     * @var string|null
     */
    private ?string $message;

    /**
     * SyncUserAccessRightsV1Response constructor.
     * @param string $messageId
     * @param SyncUserAccessRightsV1 $target
     * @param bool $success
     * @param string|null $message
     * @param string $recipientContextId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        SyncUserAccessRightsV1 $target,
        bool $success,
        ?string $message,
        string $recipientContextId,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->target = $target;
        $this->success = $success;
        $this->message = $message;
        $this->recipientContextId = $recipientContextId;
    }

    /**
     * @param SyncUserAccessRightsV1 $target
     * @param bool $success
     * @param string|null $message
     * @return static
     * @throws Exception
     */
    public static function create(SyncUserAccessRightsV1 $target, bool $success = true, string $message = null): self
    {
        return new self(
            Uuid::create(),
            $target,
            $success,
            $message,
            $target->getReplyRecipientContextId(),
            new DateTimeImmutable()
        );
    }

    /**
     * @return SyncUserAccessRightsV1
     */
    public function getTarget(): SyncUserAccessRightsV1
    {
        return $this->target;
    }

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getRecipientContextId(): string
    {
        return $this->recipientContextId;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return self::ROUTING_KEY;
    }
}
