<?php

namespace App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox;

/**
 * Interface DispatchPriorityOutboxUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox
 */
interface DispatchPriorityOutboxUseCaseInterface
{
    /**
     * @param int $limit
     * @return DispatchPriorityOutboxResponse
     */
    public function execute(int $limit): DispatchPriorityOutboxResponse;
}
