<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use App\Context\Account\Application\Common\Pagination\Pagination;
use App\Context\Account\Application\UseCase\Assembly\Output\Meta\PaginationDto;
use App\Context\Account\Application\UseCase\Assembly\Output\Model\User\UserDto;
use App\Context\Account\Domain\Model\User\User;

use function array_map;
use function iterator_to_array;

/**
 * Class UsersResponse
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
final class UsersResponse
{
    /**
     * @var PaginationDto
     */
    private PaginationDto $pagination;

    /**
     * @var UserDto[]
     */
    private array $items;

    /**
     * UsersResponse constructor.
     * @param Pagination $users
     */
    public function __construct(Pagination $users)
    {
        $this->pagination = PaginationDto::createFromPagination($users);
        $users = iterator_to_array($users->getIterator());

        $this->items = array_map(
            static function (User $user) {
                return UserDto::createFromUser($user);
            },
            $users
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
     * @return UserDto[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
