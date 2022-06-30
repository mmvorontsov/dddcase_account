<?php

namespace App\Context\Account\Domain\Service\SignCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class SignCredentialRecoveryCommand
 * @package App\Context\Account\Domain\Service\SignCredentialRecovery
 */
final class SignCredentialRecoveryCommand
{
    /**
     * @var CredentialRecovery
     */
    private CredentialRecovery $credentialRecovery;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * SignCredentialRecoveryCommand constructor.
     * @param CredentialRecovery $credentialRecovery
     * @param string $secretCode
     */
    public function __construct(CredentialRecovery $credentialRecovery, string $secretCode)
    {
        $this->credentialRecovery = $credentialRecovery;
        $this->secretCode = $secretCode;
    }

    /**
     * @return CredentialRecovery
     */
    public function getCredentialRecovery(): CredentialRecovery
    {
        return $this->credentialRecovery;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
