<?php

namespace App\Context\Account\Application\Message\Interservice\Account\ContactDataEmailUpdated;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;

/**
 * Class ContactDataEmailUpdatedV1
 * @package App\Context\Account\Application\Message\Interservice\Account\ContactDataEmailUpdated
 */
final class ContactDataEmailUpdatedV1 extends AbstractEvent implements
    InterserviceEventInterface,
    RoutableMessageInterface
{
    public const ROUTING_KEY = 'dddcase_account.contact_data_email_updated.v1';

    /**
     * @var string
     */
    private string $userId;

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
     * ContactDataEmailUpdatedV1 constructor.
     * @param string $messageId
     * @param string $userId
     * @param string $contactDataId
     * @param string $fromEmail
     * @param string $toEmail
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(
        string $messageId,
        string $userId,
        string $contactDataId,
        string $fromEmail,
        string $toEmail,
        DateTimeImmutable $occurredOn
    ) {
        parent::__construct($messageId, $occurredOn);
        $this->userId = $userId;
        $this->contactDataId = $contactDataId;
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
    }

    /**
     * @param string $userId
     * @param string $contactDataId
     * @param string $fromEmail
     * @param string $toEmail
     * @return static
     * @throws Exception
     */
    public static function create(string $userId, string $contactDataId, string $fromEmail, string $toEmail): self
    {
        return new self(
            Uuid::create(),
            $userId,
            $contactDataId,
            $fromEmail,
            $toEmail,
            new DateTimeImmutable()
        );
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

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return self::ROUTING_KEY;
    }
}
