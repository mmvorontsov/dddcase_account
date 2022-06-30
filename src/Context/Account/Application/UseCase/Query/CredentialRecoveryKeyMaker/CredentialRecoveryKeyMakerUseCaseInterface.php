<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

/**
 * Interface CredentialRecoveryKeyMakerUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
interface CredentialRecoveryKeyMakerUseCaseInterface
{
    /**
     * @param CredentialRecoveryKeyMakerRequest $request
     * @return CredentialRecoveryKeyMakerResponse
     */
    public function execute(CredentialRecoveryKeyMakerRequest $request): CredentialRecoveryKeyMakerResponse;
}
