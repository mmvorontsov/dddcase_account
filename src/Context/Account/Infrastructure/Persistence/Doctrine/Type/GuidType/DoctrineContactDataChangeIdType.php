<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;

/**
 * Class DoctrineContactDataChangeIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineContactDataChangeIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'contact_data_change__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var ContactDataChangeId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ContactDataChangeId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ContactDataChangeId
    {
        if (null === $value) {
            return null;
        }

        return ContactDataChangeId::createFrom($value);
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
