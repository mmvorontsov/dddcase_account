<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UserCredentialRequest
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 *
 * @OA\Schema(required={"userId"})
 */
final class UserCredentialRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $userId = null;

    /**
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }
}
