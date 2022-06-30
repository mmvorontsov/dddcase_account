<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineUserIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineUserIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'user__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var UserId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return UserId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if (null === $value) {
            return null;
        }

        return UserId::createFrom($value);
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
