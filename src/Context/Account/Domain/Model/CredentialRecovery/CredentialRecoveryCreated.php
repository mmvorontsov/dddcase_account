<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class CredentialRecoveryCreated
 * @package App\Context\Account\Domain\Model\CredentialRecovery
 */
final class CredentialRecoveryCreated extends DomainEvent
{
    /**
     * @var CredentialRecovery
     */
    private CredentialRecovery $credentialRecovery;

    /**
     * CredentialRecoveryCreated constructor.
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
