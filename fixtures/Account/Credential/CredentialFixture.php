<?php

namespace App\DataFixtures\Account\Credential;

use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialId;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;
use App\DataFixtures\Account\User\UserFixture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class CredentialFixture
 * @package App\DataFixtures\Account\Credential
 */
class CredentialFixture extends Fixture implements DependentFixtureInterface
{
    public const CREDENTIAL_REF_1 = 'credential_ref_1';

    /**
     * @var PasswordHasherInterface
     */
    private PasswordHasherInterface $passwordHasher;

    /**
     * CredentialFixture constructor.
     * @param PasswordHasherInterface $passwordHasher
     */
    public function __construct(PasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixture::USER_REF_1);

        $credential = new Credential(
            $user->getUserId(),
            CredentialId::create(),
            null,
            $this->passwordHasher->hash('123456'),
            new DateTimeImmutable(),
            new ArrayCollection(),
        );

        $manager->persist($credential);
        $manager->flush();

        $this->addReference(self::CREDENTIAL_REF_1, $credential);
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
