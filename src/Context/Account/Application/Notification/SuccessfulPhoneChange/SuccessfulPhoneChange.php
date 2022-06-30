<?php

namespace App\Context\Account\Application\Notification\SuccessfulPhoneChange;

use App\Context\Account\Infrastructure\Notification\NotificationInterface;

/**
 * Class SuccessfulPhoneChange
 * @package App\Context\Account\Application\Notification\SuccessfulPhoneChange
 */
final class SuccessfulPhoneChange implements NotificationInterface
{
    /**
     * @var string
     */
    private string $fromPhone;

    /**
     * @var string
     */
    private string $toPhone;

    /**
     * SuccessfulPhoneChange constructor.
     * @param string $fromPhone
     * @param string $toPhone
     */
    public function __construct(string $fromPhone, string $toPhone)
    {
        $this->fromPhone = $fromPhone;
        $this->toPhone = $toPhone;
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
