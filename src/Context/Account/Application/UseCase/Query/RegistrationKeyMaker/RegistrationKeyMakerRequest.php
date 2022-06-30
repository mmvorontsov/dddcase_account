<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class RegistrationKeyMakerRequest
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 *
 * @OA\Schema(required={"registrationId"})
 */
final class RegistrationKeyMakerRequest
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
