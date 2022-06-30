<?php

namespace App\Context\Account\Domain\Model\CredentialRecovery\Sign;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class CredentialRecoverySigned
 * @package App\Context\Account\Domain\Model\CredentialRecovery\Sign
 */
final class CredentialRecoverySigned extends DomainEvent
{
    /**
     * @var CredentialRecovery
     */
    private CredentialRecovery $credentialRecovery;

    /**
     * CredentialRecoverySigned constructor.
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
