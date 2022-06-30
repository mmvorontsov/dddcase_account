<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\KeyMakerSecretCodeDto;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class CreateContactDataChangeSecretCodeResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode
 */
final class CreateContactDataChangeSecretCodeResponse
{
    /**
     * @var KeyMakerSecretCodeDto
     */
    private KeyMakerSecretCodeDto $item;

    /**
     * CreateContactDataChangeSecretCodeResponse constructor.
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
