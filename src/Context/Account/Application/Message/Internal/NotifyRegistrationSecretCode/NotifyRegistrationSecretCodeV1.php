<?php

namespace App\Context\Account\Application\Message\Internal\NotifyRegistrationSecretCode;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Class NotifyRegistrationSecretCodeV1
 * @package App\Context\Account\Application\Message\Internal\NotifyRegistrationSecretCode
 */
final class NotifyRegistrationSecretCodeV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var NotificationRecipient
     */
    private NotificationRecipient $recipient;

    /**
     * @var string
     */
    private string $registrationId;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * NotifyRegistrationSecretCodeV1 constructor.
     * @param string $messageId
     * @param NotificationRecipient $recipient
     * @param string $registrationId
     * @param string $secretCode
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $registrationId,
        string $secretCode,
        DateTimeImmutable $createdAt,
    ) {
        parent::__construct($messageId, $createdAt);
        $this->recipient = $recipient;
        $this->registrationId = $registrationId;
        $this->secretCode = $secretCode;
    }

    /**
     * @param NotificationRecipient $recipient
     * @param string $registrationId
     * @param string $secretCode
     * @return static
     * @throws Exception
     */
    public static function create(NotificationRecipient $recipient, string $registrationId, string $secretCode): self
    {
        return new self(
            Uuid::create(),
            $recipient,
            $registrationId,
            $secretCode,
            new DateTimeImmutable(),
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
    public function getRegistrationId(): string
    {
        return $this->registrationId;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
