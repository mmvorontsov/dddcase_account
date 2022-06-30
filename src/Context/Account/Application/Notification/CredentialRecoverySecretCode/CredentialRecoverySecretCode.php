<?php

namespace App\Context\Account\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Infrastructure\Notification\NotificationInterface;

/**
 * Class CredentialRecoverySecretCode
 * @package App\Context\Account\Application\Notification\CredentialRecoverySecretCode
 */
final class CredentialRecoverySecretCode implements NotificationInterface
{
    /**
     * @var string
     */
    private string $secretCode;

    /**
     * CredentialRecoverySecretCode constructor.
     * @param string $secretCode
     */
    public function __construct(string $secretCode)
    {
        $this->secretCode = $secretCode;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
