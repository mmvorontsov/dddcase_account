<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\CredentialRecovery\CredentialRecoveryDto;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class SignCredentialRecoveryResponse
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
class SignCredentialRecoveryResponse
{
    /**
     * @var CredentialRecoveryDto
     */
    private CredentialRecoveryDto $item;

    /**
     * SignCredentialRecoveryResponse constructor.
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
