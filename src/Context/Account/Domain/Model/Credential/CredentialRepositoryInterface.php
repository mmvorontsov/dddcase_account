<?php

namespace App\Context\Account\Domain\Model\Credential;

/**
 * Interface CredentialRepositoryInterface
 * @package App\Context\Account\Domain\Model\Credential
 */
interface CredentialRepositoryInterface
{
    /**
     * @param Credential $credential
     */
    public function add(Credential $credential): void;

    /**
     * @param CredentialId $credentialId
     * @return Credential|null
     */
    public function findById(CredentialId $credentialId): ?Credential;

    /**
     * @param CredentialSelectionSpecInterface $spec
     * @return Credential|null
     */
    public function selectOneSatisfying(CredentialSelectionSpecInterface $spec): ?Credential;
}
