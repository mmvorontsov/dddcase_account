<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CredentialRecoveryKeyMakerRequest
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 *
 * @OA\Schema(required={"credentialRecoveryId"})
 */
final class CredentialRecoveryKeyMakerRequest
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
