<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SignCredentialRecoveryRequest
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 *
 * @OA\Schema(required={"credentialRecoveryId", "secretCode"})
 */
final class SignCredentialRecoveryRequest
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
    private mixed $secretCode = null;

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
    public function getSecretCode(): mixed
    {
        return $this->secretCode;
    }

    /**
     * @param mixed $secretCode
     */
    public function setSecretCode(mixed $secretCode): void
    {
        $this->secretCode = $secretCode;
    }
}
