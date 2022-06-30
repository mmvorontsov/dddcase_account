<?php

namespace App\Context\Account\Application\Message\Internal\NotifyContactDataChangeSecretCode;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Class NotifyContactDataChangeSecretCodeV1
 * @package App\Context\Account\Application\Message\Internal\NotifyContactDataChangeSecretCode
 */
final class NotifyContactDataChangeSecretCodeV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var NotificationRecipient
     */
    private NotificationRecipient $recipient;

    /**
     * @var string
     */
    private string $contactDataChangeId;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * NotifyContactDataChangeSecretCodeV1 constructor.
     * @param string $messageId
     * @param NotificationRecipient $recipient
     * @param string $contactDataChangeId
     * @param string $secretCode
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $contactDataChangeId,
        string $secretCode,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->recipient = $recipient;
        $this->contactDataChangeId = $contactDataChangeId;
        $this->secretCode = $secretCode;
    }

    /**
     * @param NotificationRecipient $recipient
     * @param string $contactDataChangeId
     * @param string $secretCode
     * @return static
     * @throws Exception
     */
    public static function create(
        NotificationRecipient $recipient,
        string $contactDataChangeId,
        string $secretCode
    ): self {
        return new self(
            Uuid::create(),
            $recipient,
            $contactDataChangeId,
            $secretCode,
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
    public function getContactDataChangeId(): string
    {
        return $this->contactDataChangeId;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
