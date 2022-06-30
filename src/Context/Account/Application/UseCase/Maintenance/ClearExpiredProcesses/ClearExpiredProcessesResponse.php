<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses;

/**
 * Class ClearExpiredProcessesResponse
 * @package App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses
 */
final class ClearExpiredProcessesResponse
{
    /**
     * @var int
     */
    private int $totalRemoved;

    /**
     * ClearExpiredProcessesResponse constructor.
     * @param int $totalRemoved
     */
    public function __construct(int $totalRemoved)
    {
        $this->totalRemoved = $totalRemoved;
    }

    /**
     * @return int
     */
    public function getTotalRemoved(): int
    {
        return $this->totalRemoved;
    }
}
