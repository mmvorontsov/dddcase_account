<?php

namespace App\Context\Account\Domain\Model\Credential\Update;

use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\Credential\Credential;
use Exception;

/**
 * Class CredentialUsernameUpdated
 * @package App\Context\Account\Domain\Model\Credential\Update
 */
final class CredentialUsernameUpdated extends DomainEvent
{
    /**
     * @var Credential
     */
    private Credential $credential;

    /**
     * @var string|null
     */
    private ?string $fromUsername;

    /**
     * CredentialUsernameUpdated constructor.
     * @param Credential $credential
     * @param string|null $fromUsername
     * @throws Exception
     */
    public function __construct(Credential $credential, ?string $fromUsername)
    {
        parent::__construct();
        $this->credential = $credential;
        $this->fromUsername = $fromUsername;
    }

    /**
     * @return Credential
     */
    public function getCredential(): Credential
    {
        return $this->credential;
    }

    /**
     * @return string|null
     */
    public function getFromUsername(): ?string
    {
        return $this->fromUsername;
    }
}
