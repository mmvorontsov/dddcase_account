<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;

/**
 * Interface CredentialRecoveryKeyMakerResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
interface CredentialRecoveryKeyMakerResponseAssemblerInterface
{
    /**
     * @param CredentialRecoveryKeyMaker $keyMaker
     * @return CredentialRecoveryKeyMakerResponse
     */
    public function assemble(CredentialRecoveryKeyMaker $keyMaker): CredentialRecoveryKeyMakerResponse;
}
