<?php

namespace App\DataFixtures\Account\User;

use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class UserFixture
 * @package App\DataFixtures\Account\User
 */
class UserFixture extends Fixture
{
    public const USER_REF_1 = 'user_ref_1';

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User(
            UserId::create(),
            'Tom',
            new DateTimeImmutable(),
            new ArrayCollection(),
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REF_1, $user);
    }
}
