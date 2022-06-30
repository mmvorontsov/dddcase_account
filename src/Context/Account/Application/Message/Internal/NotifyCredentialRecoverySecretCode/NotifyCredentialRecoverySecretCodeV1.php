<?php

namespace App\Context\Account\Application\Message\Internal\NotifyCredentialRecoverySecretCode;

use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use DateTimeImmutable;
use Exception;

/**
 * Class NotifyCredentialRecoverySecretCodeV1
 * @package App\Context\Account\Application\Message\Internal\NotifyCredentialRecoverySecretCode
 */
final class NotifyCredentialRecoverySecretCodeV1 extends AbstractCommand implements InternalCommandInterface
{
    /**
     * @var NotificationRecipient
     */
    private NotificationRecipient $recipient;

    /**
     * @var string
     */
    private string $credentialRecoveryId;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * NotifyCredentialRecoverySecretCodeV1 constructor.
     * @param string $messageId
     * @param string $credentialRecoveryId
     * @param string $secretCode
     * @param NotificationRecipient $recipient
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $credentialRecoveryId,
        string $secretCode,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->recipient = $recipient;
        $this->credentialRecoveryId = $credentialRecoveryId;
        $this->secretCode = $secretCode;
    }

    /**
     * @param NotificationRecipient $recipient
     * @param string $credentialRecoveryId
     * @param string $secretCode
     * @return static
     * @throws Exception
     */
    public static function create(
        NotificationRecipient $recipient,
        string $credentialRecoveryId,
        string $secretCode
    ): self {
        return new self(
            Uuid::create(),
            $recipient,
            $credentialRecoveryId,
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
    public function getCredentialRecoveryId(): string
    {
        return $this->credentialRecoveryId;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
