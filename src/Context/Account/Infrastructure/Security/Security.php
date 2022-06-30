<?php

namespace App\Context\Account\Infrastructure\Security;

use App\Context\Account\Infrastructure\Security\Client\Client;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

/**
 * Class Security
 * @package App\Context\Account\Infrastructure\Security
 */
final class Security implements SecurityInterface
{
    /**
     * @var SymfonySecurity
     */
    private SymfonySecurity $security;

    /**
     * Security constructor.
     * @param SymfonySecurity $security
     */
    public function __construct(SymfonySecurity $security)
    {
        $this->security = $security;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        /** @var Client|null $client */
        $client = $this->security->getUser();

        return $client;
    }
}
