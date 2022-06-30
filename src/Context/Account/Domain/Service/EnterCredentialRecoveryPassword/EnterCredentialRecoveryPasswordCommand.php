<?php

namespace App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class EnterCredentialRecoveryPasswordCommand
 * @package App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordCommand
{
    /**
     * @var CredentialRecovery
     */
    private CredentialRecovery $credentialRecovery;

    /**
     * @var string
     */
    private string $hashedPassword;

    /**
     * @var string
     */
    private string $passwordEntryCode;

    /**
     * EnterCredentialRecoveryPasswordCommand constructor.
     * @param CredentialRecovery $credentialRecovery
     * @param string $hashedPassword
     * @param string $passwordEntryCode
     */
    public function __construct(
        CredentialRecovery $credentialRecovery,
        string $hashedPassword,
        string $passwordEntryCode,
    ) {
        $this->credentialRecovery = $credentialRecovery;
        $this->hashedPassword = $hashedPassword;
        $this->passwordEntryCode = $passwordEntryCode;
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
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @return string
     */
    public function getPasswordEntryCode(): string
    {
        return $this->passwordEntryCode;
    }
}
