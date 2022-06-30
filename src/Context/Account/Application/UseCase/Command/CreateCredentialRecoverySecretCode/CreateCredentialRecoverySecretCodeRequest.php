<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateCredentialRecoverySecretCodeRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 *
 * @OA\Schema(required={"credentialRecoveryId"})
 */
final class CreateCredentialRecoverySecretCodeRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $credentialRecoveryId = null;

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
}
