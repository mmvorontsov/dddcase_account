<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\Request;

use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\CreateCredentialRecoveryRequest;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateCredentialRecoveryByPhoneRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\Request
 *
 * @OA\Schema(
 *     required={"type", "byPhone"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={PrimaryContactDataTypeEnum::PHONE},
 *         example=PrimaryContactDataTypeEnum::PHONE
 *     )
 * )
 */
final class CreateCredentialRecoveryByPhoneRequest extends CreateCredentialRecoveryRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", description="Phone number")
     */
    private mixed $byPhone = null;

    /**
     * @return mixed
     */
    public function getByPhone(): mixed
    {
        return $this->byPhone;
    }

    /**
     * @param mixed $byPhone
     */
    public function setByPhone(mixed $byPhone): void
    {
        $this->byPhone = $byPhone;
    }
}
