<?php

namespace App\Context\Account\Application\Message\Internal\ContactDataChangeSigned;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;

/**
 * Class ContactDataChangeSignedV1
 * @package App\Context\Account\Application\Message\Internal\ContactDataChangeSigned
 */
final class ContactDataChangeSignedV1 extends AbstractEvent implements InternalEventInterface
{
    /**
     * @var string
     */
    private string $contactDataChangeId;

    /**
     * ContactDataChangeSignedV1 constructor.
     * @param string $messageId
     * @param string $contactDataChangeId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, string $contactDataChangeId, DateTimeImmutable $occurredOn)
    {
        parent::__construct($messageId, $occurredOn);
        $this->contactDataChangeId = $contactDataChangeId;
    }

    /**
     * @param string $contactDataChangeId
     * @return static
     * @throws Exception
     */
    public static function create(string $contactDataChangeId): self
    {
        return new self(
            Uuid::create(),
            $contactDataChangeId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return string
     */
    public function getContactDataChangeId(): string
    {
        return $this->contactDataChangeId;
    }
}
