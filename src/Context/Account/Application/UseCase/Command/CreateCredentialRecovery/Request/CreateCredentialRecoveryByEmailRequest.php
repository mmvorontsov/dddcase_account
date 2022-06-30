<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\Request;

use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\CreateCredentialRecoveryRequest;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateCredentialRecoveryByEmailRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\Request
 *
 * @OA\Schema(
 *     required={"type", "byEmail"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={PrimaryContactDataTypeEnum::EMAIL},
 *         example=PrimaryContactDataTypeEnum::EMAIL
 *     )
 * )
 */
final class CreateCredentialRecoveryByEmailRequest extends CreateCredentialRecoveryRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", format="email", example="email@example.com")
     */
    private mixed $byEmail = null;

    /**
     * @return mixed
     */
    public function getByEmail(): mixed
    {
        return $this->byEmail;
    }

    /**
     * @param mixed $byEmail
     */
    public function setByEmail(mixed $byEmail): void
    {
        $this->byEmail = $byEmail;
    }
}
