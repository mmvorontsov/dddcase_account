<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;

/**
 * Class UserAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class UserAddition implements UserAdditionInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserAddition constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserId $id
     * @return bool
     */
    public function repositoryContainsId(UserId $id): bool
    {
        return $this->userRepository->containsId($id);
    }

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return bool
     */
    public function repositoryContainsIdOrNotFound(UserId $id, string $msg = null): bool
    {
        if (!$this->repositoryContainsId($id)) {
            throw new NotFoundException($msg ?? 'User not found.');
        }

        return true;
    }

    /**
     * @param UserId $id
     * @return bool
     */
    public function repositoryContainsIdOrForbidden(UserId $id): bool
    {
        if (!$this->repositoryContainsId($id)) {
            throw new ForbiddenException();
        }

        return true;
    }

    /**
     * @param UserId $id
     * @return User|null
     */
    public function findById(UserId $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return User
     */
    public function findByIdOrNotFound(UserId $id, string $msg = null): User
    {
        $user = $this->findById($id);
        if (null === $user) {
            throw new NotFoundException($msg ?? 'User not found.');
        }

        return $user;
    }
}
