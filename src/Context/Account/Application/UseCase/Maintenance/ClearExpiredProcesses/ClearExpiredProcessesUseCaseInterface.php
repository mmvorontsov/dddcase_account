<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses;

/**
 * Interface ClearExpiredProcessesUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses
 */
interface ClearExpiredProcessesUseCaseInterface
{
    /**
     * @param int $size
     * @return ClearExpiredProcessesResponse
     */
    public function execute(int $size): ClearExpiredProcessesResponse;
}
