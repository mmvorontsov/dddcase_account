<?php

namespace App\Context\Account\Infrastructure\Security\Hasher;

/**
 * Interface PasswordEncoderInterface
 * @package App\Context\Account\Infrastructure\Security\Hasher
 */
interface PasswordHasherInterface
{
    /**
     * @param string $plainPassword
     * @return string
     */
    public function hash(string $plainPassword): string;

    /**
     * @param string $hashedPassword
     * @param string $plainPassword
     * @return bool
     */
    public function verify(string $hashedPassword, string $plainPassword): bool;
}
