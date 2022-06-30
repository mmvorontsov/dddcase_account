<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UserByCredentialRequest
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 *
 * @OA\Schema(required={"login", "password"})
 */
final class UserByCredentialRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", description="Username, email or phone")
     */
    private mixed $login = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string")
     */
    private mixed $password = null;

    /**
     * @return mixed
     */
    public function getLogin(): mixed
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin(mixed $login): void
    {
        $this->login = $login;
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
}
