<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\CredentialRecovery\CredentialRecoveryDto;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class CreateCredentialRecoveryResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
class CreateCredentialRecoveryResponse
{
    /**
     * @var CredentialRecoveryDto
     */
    private CredentialRecoveryDto $item;

    /**
     * CreateCredentialRecoveryResponse constructor.
     * @param CredentialRecovery $contactDataChange
     */
    public function __construct(CredentialRecovery $contactDataChange)
    {
        $this->item = CredentialRecoveryDto::createFromCredentialRecovery($contactDataChange);
    }

    /**
     * @return CredentialRecoveryDto
     */
    public function getItem(): CredentialRecoveryDto
    {
        return $this->item;
    }
}
