<?php

namespace App\Context\Account\Infrastructure\Security\Client;

/**
 * Class Service
 * @package App\Context\Account\Infrastructure\Security\Client
 */
final class Service extends Client
{
    /**
     * @var string
     */
    private string $name;

    /**
     * Service constructor.
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
