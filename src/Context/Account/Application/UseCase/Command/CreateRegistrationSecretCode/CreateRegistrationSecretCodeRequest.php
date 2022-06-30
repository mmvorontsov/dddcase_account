<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CreateRegistrationSecretCodeRequest
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 *
 * @OA\Schema(required={"registrationId"})
 */
final class CreateRegistrationSecretCodeRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $registrationId = null;

    /**
     * @return mixed
     */
    public function getRegistrationId(): mixed
    {
        return $this->registrationId;
    }

    /**
     * @param mixed $registrationId
     */
    public function setRegistrationId(mixed $registrationId): void
    {
        $this->registrationId = $registrationId;
    }
}
