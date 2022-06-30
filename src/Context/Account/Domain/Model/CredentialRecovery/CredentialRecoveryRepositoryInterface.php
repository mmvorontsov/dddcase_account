<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery;

/**
 * Interface CredentialRecoveryRepositoryInterface
 * @package App\Context\Account\Domain\Model\CredentialRecovery
 */
interface CredentialRecoveryRepositoryInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     */
    public function add(CredentialRecovery $credentialRecovery): void;

    /**
     * @param CredentialRecovery $credentialRecovery
     */
    public function remove(CredentialRecovery $credentialRecovery): void;

    /**
     * @param CredentialRecoveryId $credentialRecoveryId
     * @return CredentialRecovery|null
     */
    public function findById(CredentialRecoveryId $credentialRecoveryId): ?CredentialRecovery;
}
