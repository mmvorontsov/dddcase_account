<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\KeyMakerSecretCodeDto;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class CreateRegistrationSecretCodeResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
class CreateRegistrationSecretCodeResponse
{
    /**
     * @var KeyMakerSecretCodeDto
     */
    private KeyMakerSecretCodeDto $item;

    /**
     * CreateRegistrationSecretCodeResponse constructor.
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
