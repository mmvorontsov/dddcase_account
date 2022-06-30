<?php

namespace App\Context\Account\Infrastructure\Security\Hasher;

use Symfony\Component\PasswordHasher\PasswordHasherInterface as SymfonyPasswordHasherInterface;

/**
 * Class PasswordHasher
 * @package App\Context\Account\Infrastructure\Security\Hasher
 */
final class PasswordHasher implements PasswordHasherInterface
{
    /**
     * @var SymfonyPasswordHasherInterface
     */
    private SymfonyPasswordHasherInterface $passwordHasher;

    /**
     * @var string
     */
    private string $passwordSalt;

    /**
     * PasswordHasher constructor.
     * @param SymfonyPasswordHasherInterface $passwordHasher
     * @param string $passwordSalt
     */
    public function __construct(SymfonyPasswordHasherInterface $passwordHasher, string $passwordSalt)
    {
        $this->passwordHasher = $passwordHasher;
        $this->passwordSalt = $passwordSalt;
    }

    /**
     * @inheritdoc
     */
    public function hash(string $plainPassword): string
    {
        return $this->passwordHasher->hash($plainPassword, $this->passwordSalt);
    }

    /**
     * @inheritdoc
     */
    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $this->passwordHasher->verify($hashedPassword, $plainPassword);
    }
}
