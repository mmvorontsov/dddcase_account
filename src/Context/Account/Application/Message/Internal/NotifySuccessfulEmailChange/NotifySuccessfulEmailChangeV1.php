<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulEmailChange;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Class NotifyContactDataEmailUpdatedV1
 * @package App\Context\Account\Application\Message\Internal\NotifyContactDataEmailUpdated
 */
final class NotifySuccessfulEmailChangeV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var NotificationRecipient
     */
    private NotificationRecipient $recipient;

    /**
     * @var string
     */
    private string $contactDataId;

    /**
     * @var string
     */
    private string $fromEmail;

    /**
     * @var string
     */
    private string $toEmail;

    /**
     * NotifyContactDataEmailUpdatedV1 constructor.
     * @param string $messageId
     * @param NotificationRecipient $recipient
     * @param string $contactDataId
     * @param string $fromEmail
     * @param string $toEmail
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $contactDataId,
        string $fromEmail,
        string $toEmail,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->recipient = $recipient;
        $this->contactDataId = $contactDataId;
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
    }

    /**
     * @param NotificationRecipient $recipient
     * @param string $contactDataId
     * @param string $fromEmail
     * @param string $toEmail
     * @return static
     * @throws Exception
     */
    public static function create(
        NotificationRecipient $recipient,
        string $contactDataId,
        string $fromEmail,
        string $toEmail
    ): self {
        return new self(
            Uuid::create(),
            $recipient,
            $contactDataId,
            $fromEmail,
            $toEmail,
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
    public function getContactDataId(): string
    {
        return $this->contactDataId;
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getToEmail(): string
    {
        return $this->toEmail;
    }
}
