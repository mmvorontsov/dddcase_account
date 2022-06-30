<?php

namespace App\Context\Account\Domain\Model\KeyMaker\SecretCode;

use MyCLabs\Enum\Enum;

/**
 * Class SecretCodeEnum
 * @package App\Context\Account\Domain\Model\KeyMaker\SecretCode
 */
final class SecretCodeEnum extends Enum
{
    public const ACCEPTANCE_WAITING = 'ACCEPTANCE_WAITING';
    public const ACCEPTED = 'ACCEPTED';
}
