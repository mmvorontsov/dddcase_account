<?php

namespace App\DataFixtures\Account\Permission;

use App\Context\Account\AccountContext;
use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class PermissionFixture
 * @package App\DataFixtures\Account\Permission
 */
class PermissionFixture extends Fixture
{
    public const PERMISSION_REF_1 = 'permission_ref_1';

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $permission = new Permission(
            PermissionId::createFrom(UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ),
            'Read user',
            AccountContext::CONTEXT_ID
        );

        $manager->persist($permission);
        $manager->flush();

        $this->addReference(self::PERMISSION_REF_1, $permission);
    }
}
