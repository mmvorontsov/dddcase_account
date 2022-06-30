<?php

namespace App\Context\Account\Domain\Model\Credential\Update;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\Credential\Credential;

/**
 * Class CredentialPasswordUpdated
 * @package App\Context\Account\Domain\Model\Credential\Update
 */
final class CredentialPasswordUpdated extends DomainEvent
{
    /**
     * @var Credential
     */
    private Credential $credential;

    /**
     * CredentialPasswordUpdated constructor.
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
