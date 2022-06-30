<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Context\Account\Domain\Model\Outbox\OutboxId;

/**
 * Class DoctrineOutboxIdType
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine\Type\GuidType
 */
class DoctrineOutboxIdType extends GuidType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'outbox__id';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var OutboxId|null $value */
        if (null === $value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return OutboxId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?OutboxId
    {
        if (null === $value) {
            return null;
        }

        return OutboxId::createFrom($value);
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
