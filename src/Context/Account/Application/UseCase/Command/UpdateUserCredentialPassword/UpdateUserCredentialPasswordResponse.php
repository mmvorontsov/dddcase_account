<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential\CredentialDto;
use App\Context\Account\Domain\Model\Credential\Credential;

/**
 * Class UpdateUserCredentialPasswordResponse
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
final class UpdateUserCredentialPasswordResponse
{
    /**
     * @var CredentialDto
     */
    private CredentialDto $item;

    /**
     * UpdateUserCredentialPasswordResponse constructor.
     * @param Credential $credential
     */
    public function __construct(Credential $credential)
    {
        $this->item = CredentialDto::createFromCredential($credential);
    }

    /**
     * @return CredentialDto
     */
    public function getItem(): CredentialDto
    {
        return $this->item;
    }
}
