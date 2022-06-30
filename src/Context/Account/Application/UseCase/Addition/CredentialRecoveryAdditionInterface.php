<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;

/**
 * Class CredentialRecoveryAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface CredentialRecoveryAdditionInterface
{
    /**
     * @param CredentialRecoveryId $id
     * @return CredentialRecovery|null
     */
    public function findById(CredentialRecoveryId $id): ?CredentialRecovery;

    /**
     * @param CredentialRecoveryId $id
     * @param string|null $msg
     * @return CredentialRecovery
     */
    public function findByIdOrNotFound(CredentialRecoveryId $id, string $msg = null): CredentialRecovery;
}
