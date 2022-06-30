<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request;

use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\CreateContactDataChangeRequest;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreatePhoneChangeRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request
 *
 * @OA\Schema(
 *     required={"type", "toPhone"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={PrimaryContactDataTypeEnum::PHONE},
 *         example=PrimaryContactDataTypeEnum::PHONE
 *     )
 * )
 */
final class CreatePhoneChangeRequest extends CreateContactDataChangeRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", description="Phone number")
     */
    private mixed $toPhone = null;

    /**
     * @return mixed
     */
    public function getToPhone(): mixed
    {
        return $this->toPhone;
    }

    /**
     * @param mixed $toPhone
     */
    public function setToPhone(mixed $toPhone): void
    {
        $this->toPhone = $toPhone;
    }
}
