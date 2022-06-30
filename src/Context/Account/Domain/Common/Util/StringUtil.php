<?php

namespace App\Context\Account\Domain\Common\Util;

use Exception;

use function bin2hex;
use function random_bytes;
use function round;
use function substr;

/**
 * Class StringUtil
 * @package App\Context\Account\Domain\Common\Util
 */
class StringUtil
{
    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public static function generate(int $length): string
    {
        $int = round($length / 2) + 1;

        return substr(bin2hex(random_bytes($int)), 0, $length);
    }
}
