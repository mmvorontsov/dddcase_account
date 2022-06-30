<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\CredentialRecoveryKeyMakerDto;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;

/**
 * Class CredentialRecoveryKeyMakerResponse
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
class CredentialRecoveryKeyMakerResponse
{
    /**
     * @var CredentialRecoveryKeyMakerDto
     */
    private CredentialRecoveryKeyMakerDto $item;

    /**
     * CredentialRecoveryKeyMakerResponse constructor.
     * @param CredentialRecoveryKeyMaker $keyMaker
     */
    public function __construct(CredentialRecoveryKeyMaker $keyMaker)
    {
        $this->item = CredentialRecoveryKeyMakerDto::createFromCredentialRecoveryKeyMaker($keyMaker);
    }

    /**
     * @return CredentialRecoveryKeyMakerDto
     */
    public function getItem(): CredentialRecoveryKeyMakerDto
    {
        return $this->item;
    }
}
