<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\KeyMakerSecretCodeDto;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class CreateCredentialRecoverySecretCodeResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
class CreateCredentialRecoverySecretCodeResponse
{
    /**
     * @var KeyMakerSecretCodeDto
     */
    private KeyMakerSecretCodeDto $item;

    /**
     * CreateCredentialRecoverySecretCodeResponse constructor.
     * @param SecretCode $secretCode
     */
    public function __construct(SecretCode $secretCode)
    {
        $this->item = KeyMakerSecretCodeDto::createFromSecretCode($secretCode);
    }

    /**
     * @return KeyMakerSecretCodeDto
     */
    public function getItem(): KeyMakerSecretCodeDto
    {
        return $this->item;
    }
}
