<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

/**
 * Interface CredentialRecoveryKeyMakerResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
interface CredentialRecoveryKeyMakerResponseNormalizerInterface
{
    /**
     * @param CredentialRecoveryKeyMakerResponse $response
     * @return array
     */
    public function toArray(CredentialRecoveryKeyMakerResponse $response): array;
}
