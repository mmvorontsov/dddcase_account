<?php

namespace App\Context\Account\Application\Notification\SuccessfulEmailChange;

use App\Context\Account\Infrastructure\Notification\NotificationInterface;

/**
 * Class SuccessfulEmailChange
 * @package App\Context\Account\Application\Notification\SuccessfulEmailChange
 */
final class SuccessfulEmailChange implements NotificationInterface
{
    /**
     * @var string
     */
    private string $fromEmail;

    /**
     * @var string
     */
    private string $toEmail;

    /**
     * SuccessfulEmailChange constructor.
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function __construct(string $fromEmail, string $toEmail)
    {
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
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
}
