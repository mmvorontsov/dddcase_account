<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class CreatePhoneChangeCommand
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class CreatePhoneChangeCommand
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $fromPhone;

    /**
     * @var PhoneNumber
     */
    private PhoneNumber $toPhone;

    /**
     * CreatePhoneChangeCommand constructor.
     * @param UserId $userId
     * @param PhoneNumber|null $fromPhone
     * @param PhoneNumber $toPhone
     */
    public function __construct(UserId $userId, ?PhoneNumber $fromPhone, PhoneNumber $toPhone)
    {
        $this->userId = $userId;
        $this->fromPhone = $fromPhone;
        $this->toPhone = $toPhone;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getFromPhone(): ?PhoneNumber
    {
        return $this->fromPhone;
    }

    /**
     * @return PhoneNumber
     */
    public function getToPhone(): PhoneNumber
    {
        return $this->toPhone;
    }
}
