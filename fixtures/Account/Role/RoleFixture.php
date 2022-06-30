<?php

namespace App\DataFixtures\Account\Role;

use App\Context\Account\AccountContext;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * Class RoleFixture
 * @package App\DataFixtures\Account\Permission
 */
class RoleFixture extends Fixture
{
    public const ROLE_REF_1 = 'role_ref_1';

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $role = new Role(
            RoleId::createFrom(ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN),
            AccountContext::CONTEXT_ID,
            new ArrayCollection()
        );

        $manager->persist($role);
        $manager->flush();

        $this->addReference(self::ROLE_REF_1, $role);
    }
}
