<?php

namespace App\Context\Account\Application\Common;

use function microtime;

/**
 * Class ExecutionTimeTrackerUtil
 * @package App\Context\Account\Application\Common
 */
final class ExecutionTimeTrackerUtil
{
    /**
     * @param callable $callback
     * @return float
     */
    public static function callAndTrack(callable $callback): float
    {
        $start = microtime(true);
        $callback();

        return microtime(true) - $start;
    }
}
