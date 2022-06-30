<?php

namespace App\Context\Account\Domain\Model\Registration;

use MyCLabs\Enum\Enum;

/**
 * Class RegistrationStatusEnum
 * @package App\Context\Account\Domain\Model\Registration
 */
final class RegistrationStatusEnum extends Enum
{
    public const SIGNING = 'SIGNING';
    public const DONE = 'DONE';
}
