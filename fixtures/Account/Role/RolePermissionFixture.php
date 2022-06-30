<?php

namespace App\DataFixtures\Account\Role;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;
use App\DataFixtures\Account\Permission\PermissionFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class RolePermissionFixture
 * @package App\DataFixtures\Account\Role
 */
class RolePermissionFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Role $role */
        $role = $this->getReference(RoleFixture::ROLE_REF_1);
        /** @var Permission $permission */
        $permission = $this->getReference(PermissionFixture::PERMISSION_REF_1);

        $rolePermission = new RolePermission(
            $role,
            Uuid::create(),
            $permission->getPermissionId()
        );

        $manager->persist($rolePermission);
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            RoleFixture::class,
            PermissionFixture::class,
        ];
    }
}
