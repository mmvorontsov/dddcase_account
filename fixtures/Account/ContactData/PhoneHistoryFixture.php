<?php

namespace App\DataFixtures\Account\ContactData;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class PhoneHistoryFixture
 * @package App\DataFixtures\Account\ContactData
 */
class PhoneHistoryFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var ContactData $contactData */
        $contactData = $this->getReference(ContactDataFixture::CONTACT_DATA_REF_1);

        $phoneHistory = new PhoneHistory(
            $contactData,
            Uuid::create(),
            null,
            new DateTimeImmutable()
        );

        $manager->persist($phoneHistory);
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            ContactDataFixture::class,
        ];
    }
}
