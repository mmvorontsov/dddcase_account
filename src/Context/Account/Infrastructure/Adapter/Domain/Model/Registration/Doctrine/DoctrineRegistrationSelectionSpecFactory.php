<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine;

use App\Context\Account\Domain\Model\Registration\RegistrationSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationSelectionSpecInterface;

/**
 * Class DoctrineRegistrationSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine
 */
final class DoctrineRegistrationSelectionSpecFactory implements RegistrationSelectionSpecFactoryInterface
{
    /**
     * @param int $limit
     * @return RegistrationSelectionSpecInterface
     */
    public function createIsExpiredSelectionSpec(int $limit): RegistrationSelectionSpecInterface
    {
        return new DoctrineIsExpiredSelectionSpec($limit);
    }
}
