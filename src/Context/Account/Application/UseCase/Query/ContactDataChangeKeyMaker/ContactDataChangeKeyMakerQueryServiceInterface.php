<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface ContactDataChangeKeyMakerQueryServiceInterface
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
interface ContactDataChangeKeyMakerQueryServiceInterface
{
    /**
     * @param ContactDataChangeKeyMakerRequest $request
     * @param UserId $userId
     * @return ContactDataChangeKeyMaker|null
     */
    public function findKeyMaker(ContactDataChangeKeyMakerRequest $request, UserId $userId): ?ContactDataChangeKeyMaker;
}
