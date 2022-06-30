<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UpdateUserRequest
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 *
 * @OA\Schema(required={"userId"})
 */
final class UpdateUserRequest
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
     * @OA\Property(type="string", minLength=1, example="John")
     */
    private mixed $firstname = null;

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
}
