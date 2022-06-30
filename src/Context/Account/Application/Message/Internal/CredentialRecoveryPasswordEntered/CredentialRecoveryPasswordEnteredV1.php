<?php

namespace App\Context\Account\Application\Message\Internal\CredentialRecoveryPasswordEntered;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Message\AbstractEvent;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;

/**
 * Class CredentialRecoveryPasswordEnteredV1
 * @package App\Context\Account\Application\Message\Internal\CredentialRecoveryPasswordEntered
 */
final class CredentialRecoveryPasswordEnteredV1 extends AbstractEvent implements InternalEventInterface
{
    /**
     * @var string
     */
    private string $credentialRecoveryId;

    /**
     * CredentialRecoveryPasswordEnteredV1 constructor.
     * @param string $messageId
     * @param string $credentialRecoveryId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, string $credentialRecoveryId, DateTimeImmutable $occurredOn)
    {
        parent::__construct($messageId, $occurredOn);
        $this->credentialRecoveryId = $credentialRecoveryId;
    }

    /**
     * @param string $credentialRecoveryId
     * @return static
     * @throws Exception
     */
    public static function create(string $credentialRecoveryId): self
    {
        return new self(
            Uuid::create(),
            $credentialRecoveryId,
            new DateTimeImmutable()
        );
    }

    /**
     * @return string
     */
    public function getCredentialRecoveryId(): string
    {
        return $this->credentialRecoveryId;
    }
}
