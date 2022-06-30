<?php

namespace App\Context\Account\Application\Message\Interservice\Account\ContactDataPhoneUpdated;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;

/**
 * Class ContactDataPhoneUpdatedV1
 * @package App\Context\Account\Application\Message\Interservice\Account\ContactDataPhoneUpdated
 */
final class ContactDataPhoneUpdatedV1 extends AbstractEvent implements
    InterserviceEventInterface,
    RoutableMessageInterface
{
    public const ROUTING_KEY = 'dddcase_account.contact_data_phone_updated.v1';

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
    private string $fromPhone;

    /**
     * @var string
     */
    private string $toPhone;

    /**
     * ContactDataPhoneUpdatedV1 constructor.
     * @param string $messageId
     * @param string $userId
     * @param string $contactDataId
     * @param string $fromPhone
     * @param string $toPhone
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(
        string $messageId,
        string $userId,
        string $contactDataId,
        string $fromPhone,
        string $toPhone,
        DateTimeImmutable $occurredOn
    ) {
        parent::__construct($messageId, $occurredOn);
        $this->userId = $userId;
        $this->contactDataId = $contactDataId;
        $this->fromPhone = $fromPhone;
        $this->toPhone = $toPhone;
    }

    /**
     * @param string $userId
     * @param string $contactDataId
     * @param string $fromPhone
     * @param string $toPhone
     * @return static
     * @throws Exception
     */
    public static function create(string $userId, string $contactDataId, string $fromPhone, string $toPhone): self
    {
        return new self(
            Uuid::create(),
            $userId,
            $contactDataId,
            $fromPhone,
            $toPhone,
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

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return self::ROUTING_KEY;
    }
}
