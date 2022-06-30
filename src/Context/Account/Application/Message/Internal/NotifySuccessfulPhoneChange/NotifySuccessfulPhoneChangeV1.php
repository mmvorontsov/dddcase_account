<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulPhoneChange;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractCommand;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Class NotifySuccessfulPhoneChangeV1
 * @package App\Context\Account\Application\Message\Internal\NotifySuccessfulPhoneChange
 */
final class NotifySuccessfulPhoneChangeV1 extends AbstractCommand implements InternalCommandInterface
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
    private string $fromPhone;

    /**
     * @var string
     */
    private string $toPhone;

    /**
     * NotifySuccessfulPhoneChangeV1 constructor.
     * @param string $messageId
     * @param NotificationRecipient $recipient
     * @param string $contactDataId
     * @param string $fromPhone
     * @param string $toPhone
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        string $messageId,
        NotificationRecipient $recipient,
        string $contactDataId,
        string $fromPhone,
        string $toPhone,
        DateTimeImmutable $createdAt
    ) {
        parent::__construct($messageId, $createdAt);
        $this->recipient = $recipient;
        $this->contactDataId = $contactDataId;
        $this->fromPhone = $fromPhone;
        $this->toPhone = $toPhone;
    }


    /**
     * @param NotificationRecipient $recipient
     * @param string $contactDataId
     * @param string $fromPhone
     * @param string $toPhone
     * @return static
     * @throws Exception
     */
    public static function create(
        NotificationRecipient $recipient,
        string $contactDataId,
        string $fromPhone,
        string $toPhone
    ): self {
        return new self(
            Uuid::create(),
            $recipient,
            $contactDataId,
            $fromPhone,
            $toPhone,
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
    public function getFromPhone(): string
    {
        return $this->fromPhone;
    }

    /**
     * @return string
     */
    public function getToPhone(): string
    {
        return $this->toPhone;
    }
}
