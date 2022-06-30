<?php

namespace App\Context\Account\Application\Message\Interservice;

use InvalidArgumentException;
use App\Context\Account\Application\Message\Interservice\Account\{
    ContactDataEmailUpdated\ContactDataEmailUpdatedV1,
    ContactDataPhoneUpdated\ContactDataPhoneUpdatedV1,
};
use App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\{
    Reply\SyncUserAccessRightsV1Reply,
    SyncUserAccessRightsV1,
};
use App\Context\Account\Application\Message\Interservice\Account\UserCreated\UserCreatedV1;

use function array_flip;
use function sprintf;

/**
 * Class InterserviceMessageNameConverter
 * @package App\Context\Account\Application\Message\Interservice
 */
class InterserviceMessageNameConverter implements InterserviceMessageNameConverterInterface
{
    /**
     * @var array|string[]
     */
    private static array $mapping = [
        // Account
        SyncUserAccessRightsV1::ROUTING_KEY => SyncUserAccessRightsV1::class,
        SyncUserAccessRightsV1Reply::ROUTING_KEY => SyncUserAccessRightsV1Reply::class,
        UserCreatedV1::ROUTING_KEY => UserCreatedV1::class,
        ContactDataEmailUpdatedV1::ROUTING_KEY => ContactDataEmailUpdatedV1::class,
        ContactDataPhoneUpdatedV1::ROUTING_KEY => ContactDataPhoneUpdatedV1::class,
    ];

    /**
     * @param string $class
     * @return string
     */
    public function normalize(string $class): string
    {
        $mapping = array_flip(self::$mapping);

        if (!isset($mapping[$class])) {
            throw new InvalidArgumentException(
                sprintf('Unexpected message class %s.', $class)
            );
        }

        return $mapping[$class];
    }

    /**
     * @param string $type
     * @return string
     */
    public function denormalize(string $type): string
    {
        if (!isset(self::$mapping[$type])) {
            throw new InvalidArgumentException(
                sprintf('Unexpected message type %s.', $type)
            );
        }

        return self::$mapping[$type];
    }
}
