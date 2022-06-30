<?php

namespace App\Context\Account\Domain\Model\Registration;

/**
 * Interface RegistrationRepositoryInterface
 * @package App\Context\Account\Domain\Model\Registration
 */
interface RegistrationRepositoryInterface
{
    /**
     * @param RegistrationId $registrationId
     * @return bool
     */
    public function containsId(RegistrationId $registrationId): bool;

    /**
     * @param Registration $registration
     */
    public function add(Registration $registration): void;

    /**
     * @param Registration $registration
     */
    public function remove(Registration $registration): void;

    /**
     * @param RegistrationId $registrationId
     * @return Registration|null
     */
    public function findById(RegistrationId $registrationId): ?Registration;

    /**
     * @param RegistrationSelectionSpecInterface $spec
     * @return array
     */
    public function selectSatisfying(RegistrationSelectionSpecInterface $spec): array;
}
