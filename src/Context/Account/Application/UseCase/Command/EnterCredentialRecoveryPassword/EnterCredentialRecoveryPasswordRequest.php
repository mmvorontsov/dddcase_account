<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class EnterCredentialRecoveryPasswordRequest
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 *
 * @OA\Schema(required={"credentialRecoveryId", "password", "passwordEntryCode"})
 */
final class EnterCredentialRecoveryPasswordRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $credentialRecoveryId = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", minLength=6, example="111333")
     */
    private mixed $password = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", minLength=60)
     */
    private mixed $passwordEntryCode = null;

    /**
     * @return mixed
     */
    public function getCredentialRecoveryId(): mixed
    {
        return $this->credentialRecoveryId;
    }

    /**
     * @param mixed $credentialRecoveryId
     */
    public function setCredentialRecoveryId(mixed $credentialRecoveryId): void
    {
        $this->credentialRecoveryId = $credentialRecoveryId;
    }

    /**
     * @return mixed
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPasswordEntryCode(): mixed
    {
        return $this->passwordEntryCode;
    }

    /**
     * @param mixed $passwordEntryCode
     */
    public function setPasswordEntryCode(mixed $passwordEntryCode): void
    {
        $this->passwordEntryCode = $passwordEntryCode;
    }
}
