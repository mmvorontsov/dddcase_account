<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery\EnterPassword;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class CredentialRecoveryPasswordEntered
 * @package App\Context\Account\Domain\Model\CredentialRecovery\EnterPassword
 */
final class CredentialRecoveryPasswordEntered extends DomainEvent
{
    /**
     * @var CredentialRecovery
     */
    private CredentialRecovery $credentialRecovery;

    /**
     * CredentialRecoveryPasswordEntered constructor.
     * @param CredentialRecovery $credentialRecovery
     * @throws Exception
     */
    public function __construct(CredentialRecovery $credentialRecovery)
    {
        parent::__construct();
        $this->credentialRecovery = $credentialRecovery;
    }

    /**
     * @return CredentialRecovery
     */
    public function getCredentialRecovery(): CredentialRecovery
    {
        return $this->credentialRecovery;
    }
}
