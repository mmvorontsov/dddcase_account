<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SignContactDataChangeRequest
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 *
 * @OA\Schema(required={"contactDataChangeId", "secretCode"})
 */
final class SignContactDataChangeRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $contactDataChangeId = null;

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
    public function getContactDataChangeId(): mixed
    {
        return $this->contactDataChangeId;
    }

    /**
     * @param mixed $contactDataChangeId
     */
    public function setContactDataChangeId(mixed $contactDataChangeId): void
    {
        $this->contactDataChangeId = $contactDataChangeId;
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
