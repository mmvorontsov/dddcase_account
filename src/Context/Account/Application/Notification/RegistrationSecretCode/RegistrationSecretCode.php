<?php

namespace App\Context\Account\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Infrastructure\Notification\NotificationInterface;

/**
 * Class RegistrationSecretCode
 * @package App\Context\Account\Application\Notification\RegistrationSecretCode
 */
final class RegistrationSecretCode implements NotificationInterface
{
    /**
     * @var string
     */
    private string $secretCode;

    /**
     * RegistrationSecretCode constructor.
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
