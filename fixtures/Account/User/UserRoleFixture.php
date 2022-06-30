<?php

namespace App\DataFixtures\Account\User;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserRole\UserRole;
use App\DataFixtures\Account\Role\RoleFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class UserRoleFixture
 * @package App\DataFixtures\Account\User
 */
class UserRoleFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixture::USER_REF_1);
        /** @var Role $role */
        $role = $this->getReference(RoleFixture::ROLE_REF_1);

        $userRole = new UserRole(
            $user,
            Uuid::create(),
            $role->getRoleId()
        );

        $manager->persist($userRole);
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            RoleFixture::class,
        ];
    }
}
