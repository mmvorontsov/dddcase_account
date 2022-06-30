<?php

namespace App\DataFixtures\Account\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataId;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;
use App\DataFixtures\Account\User\UserFixture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class ContactDataFixture
 * @package App\DataFixtures\Account\ContactData
 */
class ContactDataFixture extends Fixture implements DependentFixtureInterface
{
    public const CONTACT_DATA_REF_1 = 'contact_data_ref_1';

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixture::USER_REF_1);

        $contactData = new ContactData(
            UserId::create(),
            ContactDataId::create(),
            EmailAddress::createFrom('tom@example.com'),
            PhoneNumber::createFrom('+12345678901'),
            new DateTimeImmutable(),
            new ArrayCollection(),
            new ArrayCollection()
        );

        $manager->persist($contactData);
        $manager->flush();

        $this->addReference(self::CONTACT_DATA_REF_1, $contactData);
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
