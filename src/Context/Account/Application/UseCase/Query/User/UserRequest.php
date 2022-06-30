<?php

namespace App\Context\Account\Application\UseCase\Query\User;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UserRequest
 * @package App\Context\Account\Application\UseCase\Query\User
 *
 * @OA\Schema(required={"userId"})
 */
final class UserRequest
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
