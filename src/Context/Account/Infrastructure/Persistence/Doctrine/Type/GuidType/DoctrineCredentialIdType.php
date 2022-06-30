<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\Credential\CredentialId;

/**
 * Class DoctrineCredentialIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineCredentialIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'credential__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var CredentialId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return CredentialId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?CredentialId
    {
        if (null === $value) {
            return null;
        }

        return CredentialId::createFrom($value);
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
