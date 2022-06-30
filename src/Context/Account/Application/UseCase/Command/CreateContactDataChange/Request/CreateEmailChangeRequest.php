<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request;

use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\CreateContactDataChangeRequest;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateEmailChangeRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request
 *
 * @OA\Schema(
 *     required={"type", "toEmail"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={PrimaryContactDataTypeEnum::EMAIL},
 *         example=PrimaryContactDataTypeEnum::EMAIL
 *     )
 * )
 */
final class CreateEmailChangeRequest extends CreateContactDataChangeRequest
{
    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", format="email", example="email@example.com")
     */
    private mixed $toEmail = null;

    /**
     * @return mixed
     */
    public function getToEmail(): mixed
    {
        return $this->toEmail;
    }

    /**
     * @param mixed $toEmail
     */
    public function setToEmail(mixed $toEmail): void
    {
        $this->toEmail = $toEmail;
    }
}
