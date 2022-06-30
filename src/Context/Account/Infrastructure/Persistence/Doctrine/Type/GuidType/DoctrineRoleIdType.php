<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Context\Account\Domain\Model\Role\RoleId;

/**
 * Class DoctrineRoleIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineRoleIdType extends StringType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'role__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var RoleId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return RoleId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?RoleId
    {
        if (null === $value) {
            return null;
        }

        return RoleId::createFrom($value);
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
