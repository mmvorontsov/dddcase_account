<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\DataType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Context\Account\Domain\Common\Type\EmailAddress;

/**
 * Class DoctrineEmailAddressType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\DataType
 */
class DoctrineEmailAddressType extends StringType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'email_address';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var EmailAddress|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return EmailAddress|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?EmailAddress
    {
        if (null === $value) {
            return null;
        }

        return EmailAddress::createFrom($value);
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
