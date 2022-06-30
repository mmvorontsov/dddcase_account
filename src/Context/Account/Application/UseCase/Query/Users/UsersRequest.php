<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UsersRequest
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
final class UsersRequest
{
    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="array", @OA\Items(type="string", format="uuid"))
     */
    private mixed $userId = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="string", example="John")
     */
    private mixed $firstname = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="integer", minimum=1, default=1)
     */
    private mixed $page = null;

    /**
     * @var mixed
     *
     * @Groups({"query"})
     * @OA\Property(type="integer", minimum=1, maximum=100, default=50, example=50)
     */
    private mixed $limit = null;

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
    public function getFirstname(): mixed
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname(mixed $firstname): void
    {
        $this->firstname = $firstname;
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
