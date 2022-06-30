<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulPasswordChange;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Class NotifySuccessfulPasswordChangeV1
 * @package App\Context\Account\Application\Message\Internal\NotifySuccessfulPasswordChange
 */
final class NotifySuccessfulPasswordChangeV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var NotificationRecipient
     */
    private NotificationRecipient $recipient;

    /**
     * @var string
     */
    private string $credentialId;

    /**
     * NotifySuccessfulPasswordChangeV1 constructor.
     * @param string $messageId
     * @param NotificationRecipient $recipient
     * @param string $credentialId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $credentialId,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->messageId = $messageId;
        $this->recipient = $recipient;
        $this->credentialId = $credentialId;
        $this->createdAt = $createdAt;
    }

    /**
     * @param NotificationRecipient $recipient
     * @param string $credentialId
     * @return static
     * @throws Exception
     */
    public static function create(NotificationRecipient $recipient, string $credentialId): self
    {
        return new self(
            Uuid::create(),
            $recipient,
            $credentialId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return NotificationRecipient
     */
    public function getRecipient(): NotificationRecipient
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getCredentialId(): string
    {
        return $this->credentialId;
    }
}
