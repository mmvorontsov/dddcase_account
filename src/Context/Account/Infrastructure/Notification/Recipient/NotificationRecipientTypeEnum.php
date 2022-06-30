<?php

namespace App\Context\Account\Infrastructure\Notification\Recipient;

use MyCLabs\Enum\Enum;

/**
 * Class NotificationRecipientTypeEnum
 * @package App\Context\Account\Infrastructure\Notification\Recipient
 */
final class NotificationRecipientTypeEnum extends Enum
{
    public const EMAIL = 'EMAIL';
    public const SMS = 'SMS';
}
