<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class RoleRequest
 * @package App\Context\Account\Application\UseCase\Query\Role
 *
 * @OA\Schema(required={"roleId"})
 */
final class RoleRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", minLength=6, example="ROLE_USER")
     */
    private mixed $roleId = null;

    /**
     * @return mixed
     */
    public function getRoleId(): mixed
    {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId(mixed $roleId): void
    {
        $this->roleId = $roleId;
    }
}
