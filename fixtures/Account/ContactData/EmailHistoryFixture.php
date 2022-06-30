<?php

namespace App\DataFixtures\Account\ContactData;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class EmailHistoryFixture
 * @package App\DataFixtures\Account\ContactData
 */
class EmailHistoryFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var ContactData $contactData */
        $contactData = $this->getReference(ContactDataFixture::CONTACT_DATA_REF_1);

        $emailHistory = new EmailHistory(
            $contactData,
            Uuid::create(),
            null,
            new DateTimeImmutable()
        );

        $manager->persist($emailHistory);
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
