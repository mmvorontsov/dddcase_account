<?php

namespace App\System\Common\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class RegexEnum
 * @package App\System\Common\Enum
 */
final class RegexEnum extends Enum
{
    public const UUID = '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$';
}
