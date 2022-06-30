<?php

namespace App\Context\Account\Domain\Service\SignRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Role\RoleId;

/**
 * Class SignRegistrationCommand
 * @package App\Context\Account\Domain\Service\SignRegistration
 */
final class SignRegistrationCommand
{
    /**
     * @var Registration
     */
    private Registration $registration;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * @var RoleId[]
     */
    private array $roleIds;

    /**
     * SignRegistrationCommand constructor.
     * @param Registration $registration
     * @param string $secretCode
     * @param array $roleIds
     */
    public function __construct(Registration $registration, string $secretCode, array $roleIds)
    {
        $this->registration = $registration;
        $this->secretCode = $secretCode;
        $this->roleIds = $roleIds;
    }

    /**
     * @return Registration
     */
    public function getRegistration(): Registration
    {
        return $this->registration;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }

    /**
     * @return RoleId[]
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
    }
}
