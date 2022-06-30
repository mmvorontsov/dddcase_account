<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\Security\AccessControl\AuthorizationCheckerInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;

/**
 * Class AuthorizationCheckerAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class AuthorizationCheckerAddition implements AuthorizationCheckerAdditionInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private AuthorizationCheckerInterface $authorizationChecker;

    /**
     * AuthorizationCheckerAddition constructor.
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function canOrForbidden(array $permissions): bool
    {
        if (!$this->can($permissions)) {
            throw new ForbiddenException();
        }

        return true;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function can(array $permissions): bool
    {
        return $this->authorizationChecker->can($permissions);
    }

    /**
     * @param array $roles
     * @return bool
     */
    public function beOr(array $roles): bool
    {
        return $this->authorizationChecker->beOr($roles);
    }
}
