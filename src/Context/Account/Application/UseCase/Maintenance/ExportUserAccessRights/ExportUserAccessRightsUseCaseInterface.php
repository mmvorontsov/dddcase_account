<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights;

/**
 * Interface ExportUserAccessRightsUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights
 */
interface ExportUserAccessRightsUseCaseInterface
{
    /**
     * @return ExportUserAccessRightsResponse
     */
    public function execute(): ExportUserAccessRightsResponse;
}
