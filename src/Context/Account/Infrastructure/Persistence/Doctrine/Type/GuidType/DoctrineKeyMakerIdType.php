<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerId;

/**
 * Class DoctrineKeyMakerIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineKeyMakerIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'key_maker__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var KeyMakerId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return KeyMakerId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?KeyMakerId
    {
        if (null === $value) {
            return null;
        }

        return KeyMakerId::createFrom($value);
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
