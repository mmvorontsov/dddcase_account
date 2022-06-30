<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;

/**
 * Class CreateContactDataChangeRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 *
 * @OA\Schema(required={"type"})
 */
class CreateContactDataChangeRequest
{
    /**
     * @var mixed
     *
     * @OA\Property(type="string", enum={
     *     PrimaryContactDataTypeEnum::EMAIL,
     *     PrimaryContactDataTypeEnum::PHONE
     * })
     */
    private mixed $type = null;

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(mixed $type): void
    {
        $this->type = $type;
    }
}
