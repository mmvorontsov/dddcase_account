<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class UserContactDataRequest
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 *
 * @OA\Schema(required={"userId"})
 */
final class UserContactDataRequest
{
    /**
     * @var mixed
     *
     * @Groups({"path"})
     * @OA\Property(type="string", format="uuid")
     */
    private mixed $userId = null;

    /**
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }
}
