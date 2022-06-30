<?php

namespace App\Context\Account\Application\Message\Internal\RegistrationSigned;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;

/**
 * Class RegistrationSignedV1
 * @package App\Context\Account\Application\Message\Internal\RegistrationSigned
 */
final class RegistrationSignedV1 extends AbstractEvent implements InternalEventInterface
{
    /**
     * @var string
     */
    private string $registrationId;

    /**
     * RegistrationSignedV1 constructor.
     * @param string $messageId
     * @param string $registrationId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, string $registrationId, DateTimeImmutable $occurredOn)
    {
        parent::__construct($messageId, $occurredOn);
        $this->registrationId = $registrationId;
    }

    /**
     * @param string $registrationId
     * @return static
     * @throws Exception
     */
    public static function create(string $registrationId): self
    {
        return new self(
            Uuid::create(),
            $registrationId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return string
     */
    public function getRegistrationId(): string
    {
        return $this->registrationId;
    }
}
