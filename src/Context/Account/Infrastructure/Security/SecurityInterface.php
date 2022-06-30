<?php

namespace App\Context\Account\Infrastructure\Security;

use App\Context\Account\Infrastructure\Security\Client\Client;

/**
 * Interface SecurityInterface
 * @package App\Context\Account\Infrastructure\Security
 */
interface SecurityInterface
{
    /**
     * @return Client|null
     */
    public function getClient(): ?Client;
}
