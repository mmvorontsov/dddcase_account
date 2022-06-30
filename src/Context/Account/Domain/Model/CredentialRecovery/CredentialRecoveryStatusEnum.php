<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery;

use MyCLabs\Enum\Enum;

/**
 * Class CredentialRecoveryStatusEnum
 * @package App\Context\Account\Domain\Model\CredentialRecovery
 */
final class CredentialRecoveryStatusEnum extends Enum
{
    public const SIGNING = 'SIGNING';
    public const PASSWORD_ENTRY = 'PASSWORD_ENTRY';
    public const DONE = 'DONE';
}
