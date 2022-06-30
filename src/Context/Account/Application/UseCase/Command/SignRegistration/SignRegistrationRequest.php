<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SignRegistrationRequest
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 *
 * @OA\Schema(required={"registrationId", "secretCode"})
 */
final class SignRegistrationRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $registrationId = null;

    /**
     * @var mixed
     *
     * @Groups({"body"})
     * @OA\Property(type="string", minLength=6, example="111333")
     */
    private mixed $secretCode = null;

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

    /**
     * @return mixed
     */
    public function getSecretCode(): mixed
    {
        return $this->secretCode;
    }

    /**
     * @param mixed $secretCode
     */
    public function setSecretCode(mixed $secretCode): void
    {
        $this->secretCode = $secretCode;
    }
}
