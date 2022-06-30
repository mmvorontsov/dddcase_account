<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights;

/**
 * Class ExportUserAccessRightsResponse
 * @package App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights
 */
final class ExportUserAccessRightsResponse
{
    /**
     * @var string
     */
    private string $outboxId;

    /**
     * ExportUserAccessRightsResponse constructor.
     * @param string $outboxId
     */
    public function __construct(string $outboxId)
    {
        $this->outboxId = $outboxId;
    }

    /**
     * @return string
     */
    public function getOutboxId(): string
    {
        return $this->outboxId;
    }
}
