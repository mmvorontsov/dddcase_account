<?php

namespace App\Context\Account\Domain\Model\User;

/**
 * Interface UserRepositoryInterface
 * @package App\Context\Account\Domain\Model\User
 */
interface UserRepositoryInterface
{
    /**
     * @param UserId $userId
     * @return bool
     */
    public function containsId(UserId $userId): bool;

    /**
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * @param UserId $userId
     * @return User|null
     */
    public function findById(UserId $userId): ?User;

    /**
     * @param UserSelectionSpecInterface $spec
     * @return User[]
     */
    public function selectSatisfying(UserSelectionSpecInterface $spec): array;
}
