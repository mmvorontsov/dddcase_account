<?php

namespace App\Context\Account\Infrastructure\Security\Client;

use InvalidArgumentException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * Class Client
 * @package App\Context\Account\Infrastructure\Security\Client
 */
abstract class Client implements JWTUserInterface
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var array
     */
    protected array $roles;

    /**
     * Client constructor.
     * @param string $id
     * @param array $roles
     */
    protected function __construct(string $id, array $roles)
    {
        $this->id = $id;
        $this->roles = $roles;
    }

    /**
     * @param string $username
     * @param array $payload
     * @return static
     */
    public static function createFromPayload($username, array $payload): self
    {
        return match ($payload['type']) {
            'user' => new User(
                $payload['id'],
                $payload['roles'],
                $payload['name'],
            ),
            'service' => new Service(
                $payload['id'],
                $payload['roles'],
                $payload['name'],
            ),
            default => throw new InvalidArgumentException('Client type does not support.'),
        };
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        //
    }
}
