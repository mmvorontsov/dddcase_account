<?php

namespace App\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\Event\DomainEvent;
use Exception;

/**
 * Class CredentialCreated
 * @package App\Context\Account\Domain\Model\Credential
 */
final class CredentialCreated extends DomainEvent
{
    /**
     * @var Credential
     */
    private Credential $credential;

    /**
     * CredentialCreated constructor.
     * @param Credential $credential
     * @throws Exception
     */
    public function __construct(Credential $credential)
    {
        parent::__construct();
        $this->credential = $credential;
    }

    /**
     * @return Credential
     */
    public function getCredential(): Credential
    {
        return $this->credential;
    }
}
