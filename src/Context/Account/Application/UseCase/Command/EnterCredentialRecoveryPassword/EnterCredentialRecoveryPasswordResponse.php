<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\CredentialRecovery\CredentialRecoveryDto;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class EnterCredentialRecoveryPasswordResponse
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
class EnterCredentialRecoveryPasswordResponse
{
    /**
     * @var CredentialRecoveryDto
     */
    private CredentialRecoveryDto $item;

    /**
     * EnterCredentialRecoveryPasswordResponse constructor.
     * @param CredentialRecovery $credentialRecovery
     */
    public function __construct(CredentialRecovery $credentialRecovery)
    {
        $this->item = CredentialRecoveryDto::createFromCredentialRecovery($credentialRecovery);
    }

    /**
     * @return CredentialRecoveryDto
     */
    public function getItem(): CredentialRecoveryDto
    {
        return $this->item;
    }
}
