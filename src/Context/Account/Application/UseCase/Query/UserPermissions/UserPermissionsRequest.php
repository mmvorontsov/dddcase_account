<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UserPermissionsRequest
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 *
 * @OA\Schema(required={"userId"})
 */
final class UserPermissionsRequest
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
