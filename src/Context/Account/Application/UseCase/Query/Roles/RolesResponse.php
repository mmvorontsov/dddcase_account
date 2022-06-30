<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use App\Context\Account\Application\Common\Pagination\Pagination;
use App\Context\Account\Application\UseCase\Assembly\Output\Meta\PaginationDto;
use App\Context\Account\Application\UseCase\Assembly\Output\Model\Role\RoleDto;
use App\Context\Account\Domain\Model\Role\Role;

use function array_map;
use function iterator_to_array;

/**
 * Class RolesResponse
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
final class RolesResponse
{
    /**
     * @var PaginationDto
     */
    private PaginationDto $pagination;

    /**
     * @var RoleDto[]
     */
    private array $items;

    /**
     * RolesResponse constructor.
     * @param Pagination $roles
     */
    public function __construct(Pagination $roles)
    {
        $this->pagination = PaginationDto::createFromPagination($roles);
        $roles = iterator_to_array($roles->getIterator());

        $this->items = array_map(
            static function (Role $role) {
                return RoleDto::createFromRole($role);
            },
            $roles
        );
    }

    /**
     * @return PaginationDto
     */
    public function getPagination(): PaginationDto
    {
        return $this->pagination;
    }

    /**
     * @return RoleDto[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
