<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class ContactDataChangeKeyMakerRequest
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 *
 * @OA\Schema(required={"contactDataChangeId"})
 */
final class ContactDataChangeKeyMakerRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $contactDataChangeId = null;

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
}
