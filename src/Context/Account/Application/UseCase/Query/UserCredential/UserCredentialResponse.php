<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential\CredentialDto;
use App\Context\Account\Domain\Model\Credential\Credential;

/**
 * Class UserCredentialResponse
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
final class UserCredentialResponse
{
    /**
     * @var CredentialDto
     */
    private CredentialDto $item;

    /**
     * UserCredentialResponse constructor.
     * @param Credential $item
     */
    public function __construct(Credential $item)
    {
        $this->item = CredentialDto::createFromCredential($item);
    }

    /**
     * @return CredentialDto
     */
    public function getItem(): CredentialDto
    {
        return $this->item;
    }
}
