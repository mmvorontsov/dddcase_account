<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UpdateUserRolesRequest
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 *
 * @OA\Schema(required={"userId"})
 */
final class UpdateUserRolesRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $userId = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="array", @OA\Items(type="string"))
     */
    private mixed $roleIds = null;

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

    /**
     * @return mixed
     */
    public function getRoleIds(): mixed
    {
        return $this->roleIds;
    }

    /**
     * @param mixed $roleIds
     */
    public function setRoleIds(mixed $roleIds): void
    {
        $this->roleIds = $roleIds;
    }
}
