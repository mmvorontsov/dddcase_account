<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Permission;

use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Permission\Permission;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class PermissionTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Permission
 */
class PermissionTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    /**
     * @throws Exception
     */
    public function testCreate(): void
    {
        $permission = Permission::create(
            'PERMISSION__USER_READ',
            'Description',
            'context_id',
        );

        self::assertSame('PERMISSION__USER_READ', $permission->getPermissionId()->getValue());
        self::assertSame('context_id', $permission->getOwner());
    }
}
