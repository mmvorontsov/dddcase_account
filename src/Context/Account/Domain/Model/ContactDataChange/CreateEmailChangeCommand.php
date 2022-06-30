<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class CreateEmailChangeCommand
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class CreateEmailChangeCommand
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $fromEmail;

    /**
     * @var EmailAddress
     */
    private EmailAddress $toEmail;

    /**
     * CreateEmailChangeCommand constructor.
     * @param UserId $userId
     * @param EmailAddress|null $fromEmail
     * @param EmailAddress $toEmail
     */
    public function __construct(UserId $userId, ?EmailAddress $fromEmail, EmailAddress $toEmail)
    {
        $this->userId = $userId;
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return EmailAddress|null
     */
    public function getFromEmail(): ?EmailAddress
    {
        return $this->fromEmail;
    }

    /**
     * @return EmailAddress
     */
    public function getToEmail(): EmailAddress
    {
        return $this->toEmail;
    }
}
