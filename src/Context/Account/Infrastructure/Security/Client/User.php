<?php

namespace App\Context\Account\Infrastructure\Security\Client;

/**
 * Class User
 * @package App\Context\Account\Infrastructure\Security\Client
 */
class User extends Client
{
    /**
     * @var string
     */
    private string $name;

    /**
     * User constructor.
     * @param string $id
     * @param array $roles
     * @param string $name
     */
    public function __construct(string $id, array $roles, string $name)
    {
        parent::__construct($id, $roles);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
