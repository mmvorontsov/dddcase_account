<?php

namespace App\DataFixtures\Account\Credential;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\PasswordHistory\PasswordHistory;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class PasswordHistoryFixture
 * @package App\DataFixtures\Account\Credential
 */
class PasswordHistoryFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @var PasswordHasherInterface
     */
    private PasswordHasherInterface $passwordHasher;

    /**
     * PasswordHistoryFixture constructor.
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
        /** @var Credential $credential */
        $credential = $this->getReference(CredentialFixture::CREDENTIAL_REF_1);

        $passwordHistory = new PasswordHistory(
            $credential,
            Uuid::create(),
            $this->passwordHasher->hash('111111'),
            new DateTimeImmutable()
        );

        $manager->persist($passwordHistory);
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            CredentialFixture::class,
        ];
    }
}
