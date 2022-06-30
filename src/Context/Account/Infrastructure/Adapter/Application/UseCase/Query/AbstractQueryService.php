<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query;

use function is_array;

/**
 * Class AbstractQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query
 */
abstract class AbstractQueryService
{
    /**
     * @param $value
     * @return array
     */
    protected function getValueAsArray($value): array
    {
        return !is_array($value) ? [$value] : $value;
    }
}
