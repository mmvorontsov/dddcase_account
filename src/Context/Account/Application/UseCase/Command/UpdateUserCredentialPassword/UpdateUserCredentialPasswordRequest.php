<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UpdateUserCredentialPasswordRequest
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 *
 * @OA\Schema(required={"userId", "password", "currentPassword"})
 */
final class UpdateUserCredentialPasswordRequest
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
     * @OA\Property(type="string", minLength=5, example="123456")
     */
    private mixed $password = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", minLength=5, example="123456")
     */
    private mixed $currentPassword = null;

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
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCurrentPassword(): mixed
    {
        return $this->currentPassword;
    }

    /**
     * @param mixed $currentPassword
     */
    public function setCurrentPassword(mixed $currentPassword): void
    {
        $this->currentPassword = $currentPassword;
    }
}
