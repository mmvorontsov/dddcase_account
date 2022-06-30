<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class RegistrationAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface RegistrationAdditionInterface
{
    /**
     * @param RegistrationId $id
     * @return bool
     */
    public function repositoryContainsId(RegistrationId $id): bool;

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return bool
     */
    public function repositoryContainsIdOrNotFound(RegistrationId $id, string $msg = null): bool;

    /**
     * @param RegistrationId $id
     * @return Registration|null
     */
    public function findById(RegistrationId $id): ?Registration;

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return Registration
     */
    public function findByIdOrNotFound(RegistrationId $id, string $msg = null): Registration;
}
