<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;

/**
 * Class CreateCredentialRecoveryResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CredentialRecoveryKeyMakerResponseAssembler implements CredentialRecoveryKeyMakerResponseAssemblerInterface
{
    /**
     * @param CredentialRecoveryKeyMaker $keyMaker
     * @return CredentialRecoveryKeyMakerResponse
     */
    public function assemble(CredentialRecoveryKeyMaker $keyMaker): CredentialRecoveryKeyMakerResponse
    {
        return new CredentialRecoveryKeyMakerResponse($keyMaker);
    }
}
