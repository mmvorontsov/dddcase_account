<?php

namespace App\Context\Account\Domain\Common\Util;

use App\Context\Account\Domain\Common\Type\StringId;

use function array_udiff;
use function array_uintersect;

/**
 * Class ArrayUtil
 * @package App\Context\Account\Domain\Common\Util
 */
class ArrayUtil
{
    /**
     * @param StringId[] $idsA
     * @param StringId[] $idsB
     * @return array
     */
    public static function stringIdsIntersect(array $idsA, array $idsB): array
    {
        return array_uintersect(
            $idsA,
            $idsB,
            fn(StringId $idA, StringId $idB) => $idA->getValue() <=> $idB->getValue()
        );
    }

    /**
     * @param StringId[] $idsA
     * @param StringId[] $idsB
     * @return array
     */
    public static function stringIdsDiff(array $idsA, array $idsB): array
    {
        return array_udiff(
            $idsA,
            $idsB,
            fn(StringId $idA, StringId $idB) => $idA->getValue() <=> $idB->getValue()
        );
    }
}
