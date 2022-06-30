<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class DoctrineRegistrationIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineRegistrationIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'registration__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var RegistrationId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return RegistrationId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?RegistrationId
    {
        if (null === $value) {
            return null;
        }

        return RegistrationId::createFrom($value);
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
