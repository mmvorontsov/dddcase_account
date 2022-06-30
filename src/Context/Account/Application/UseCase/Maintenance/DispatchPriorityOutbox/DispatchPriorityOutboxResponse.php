<?php

namespace App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox;

/**
 * Class DispatchPriorityOutboxResponse
 * @package App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox
 */
final class DispatchPriorityOutboxResponse
{
    /**
     * @var int
     */
    private int $totalDispatched;

    /**
     * DispatchPriorityOutboxResponse constructor.
     * @param int $totalDispatched
     */
    public function __construct(int $totalDispatched)
    {
        $this->totalDispatched = $totalDispatched;
    }

    /**
     * @return int
     */
    public function getTotalDispatched(): int
    {
        return $this->totalDispatched;
    }
}
