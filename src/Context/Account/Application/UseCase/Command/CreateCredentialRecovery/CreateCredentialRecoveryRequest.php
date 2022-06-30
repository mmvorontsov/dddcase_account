<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateCredentialRecoveryRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 *
 * @OA\Schema(required={"type"})
 */
class CreateCredentialRecoveryRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
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
