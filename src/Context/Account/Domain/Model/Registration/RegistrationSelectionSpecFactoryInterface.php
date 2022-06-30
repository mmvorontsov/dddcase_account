<?php

namespace App\Context\Account\Domain\Model\Registration;

/**
 * Interface RegistrationSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\Registration
 */
interface RegistrationSelectionSpecFactoryInterface
{
    /**
     * @param int $limit
     * @return RegistrationSelectionSpecInterface
     */
    public function createIsExpiredSelectionSpec(int $limit): RegistrationSelectionSpecInterface;
}
