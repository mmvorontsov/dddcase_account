<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;

/**
 * Class DoctrineCredentialRecoveryIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineCredentialRecoveryIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'credential_recovery__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var CredentialRecoveryId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return CredentialRecoveryId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?CredentialRecoveryId
    {
        if (null === $value) {
            return null;
        }

        return CredentialRecoveryId::createFrom($value);
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
