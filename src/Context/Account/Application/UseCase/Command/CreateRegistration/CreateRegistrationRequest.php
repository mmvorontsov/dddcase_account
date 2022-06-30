<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateRegistrationRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 *
 * @OA\Schema(required={"firstname", "password", "email"})
 */
final class CreateRegistrationRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", minLength=1, example="Tom")
     */
    private mixed $firstname = null;

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
     * @OA\Property(type="string", format="email", example="tom@example.com")
     */
    private mixed $email = null;

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
    public function getEmail(): mixed
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(mixed $email): void
    {
        $this->email = $email;
    }
}
