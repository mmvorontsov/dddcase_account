<?php

namespace App\Context\Account\Domain\Common\Util;

use Exception;

use function random_int;

/**
 * Class NumberUtil
 * @package App\Context\Account\Domain\Common\Util
 */
class NumberUtil
{
    /**
     * @param int $min
     * @param int $max
     * @return int
     * @throws Exception
     */
    public static function generate(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
