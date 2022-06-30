<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class RolesRequest
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
final class RolesRequest
{
    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="array", @OA\Items(type="string", format="uuid"))
     */
    private mixed $roleId = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="string", example="BaseOwner")
     */
    private mixed $owner = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="integer", minimum=1)
     */
    private mixed $page = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="integer", minimum=1, maximum=100)
     */
    private mixed $limit = null;

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

    /**
     * @return mixed
     */
    public function getOwner(): mixed
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner(mixed $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getPage(): mixed
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage(mixed $page): void
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getLimit(): mixed
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit(mixed $limit): void
    {
        $this->limit = $limit;
    }
}
