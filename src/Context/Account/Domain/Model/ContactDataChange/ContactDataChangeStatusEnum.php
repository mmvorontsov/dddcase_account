<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use MyCLabs\Enum\Enum;

/**
 * Class ContactDataChangeStatusEnum
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class ContactDataChangeStatusEnum extends Enum
{
    public const SIGNING = 'SIGNING';
    public const DONE = 'DONE';
}
