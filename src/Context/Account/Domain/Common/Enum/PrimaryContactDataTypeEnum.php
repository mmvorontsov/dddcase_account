<?php

namespace App\Context\Account\Domain\Common\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class PrimaryContactDataTypeEnum
 * @package App\Context\Account\Domain\Common\Enum
 */
class PrimaryContactDataTypeEnum extends Enum
{
    public const EMAIL = 'EMAIL';
    public const PHONE = 'PHONE';
}
