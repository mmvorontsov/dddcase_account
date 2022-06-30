<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\User;

use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserRole\UserRole;
use DateTimeImmutable;
use OpenApi\Annotations as OA;

/**
 * Class UserDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\User
 */
final class UserDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $userId;

    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var string[]
     */
    private array $roleIds;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * UserDto constructor.
     * @param string $userId
     * @param string $firstname
     * @param array $roleIds
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(string $userId, string $firstname, array $roleIds, DateTimeImmutable $createdAt)
    {
        $this->userId = $userId;
        $this->firstname = $firstname;
        $this->roleIds = $roleIds;
        $this->createdAt = $createdAt;
    }

    /**
     * @param User $user
     * @return static
     */
    public static function createFromUser(User $user): self
    {
        return new self(
            $user->getUserId()->getValue(),
            $user->getFirstname(),
            $user->getUserRoles()
                ->map(
                    static function (UserRole $userRole) {
                        return $userRole->getRoleId()->getValue();
                    },
                )
                ->getValues(),
            $user->getCreatedAt(),
        );
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string[]
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
