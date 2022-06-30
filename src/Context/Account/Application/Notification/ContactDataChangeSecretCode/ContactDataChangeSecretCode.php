<?php

namespace App\Context\Account\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Infrastructure\Notification\NotificationInterface;

/**
 * Class ContactDataChangeSecretCode
 * @package App\Context\Account\Application\Notification\ContactDataChangeSecretCode
 */
final class ContactDataChangeSecretCode implements NotificationInterface
{
    /**
     * @var string
     */
    private string $secretCode;

    /**
     * ContactDataChangeSecretCode constructor.
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
