<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\DataType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Context\Account\Domain\Common\Type\PhoneNumber;

/**
 * Class DoctrinePhoneNumberType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\DataType
 */
class DoctrinePhoneNumberType extends StringType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'phone_number';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var PhoneNumber|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return PhoneNumber|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?PhoneNumber
    {
        if (null === $value) {
            return null;
        }

        return PhoneNumber::createFrom($value);
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
