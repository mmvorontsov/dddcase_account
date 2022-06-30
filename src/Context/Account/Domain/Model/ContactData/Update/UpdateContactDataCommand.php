<?php

namespace App\Context\Account\Domain\Model\ContactData\Update;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;

/**
 * Class UpdateContactDataCommand
 * @package App\Context\Account\Domain\Model\ContactData\Update
 */
final class UpdateContactDataCommand
{
    public const EMAIL = 'EMAIL';
    public const PHONE = 'PHONE';
    
    /**
     * @var array<string, array>
     */
    private array $data = [];

    /**
     * @param EmailAddress $email
     * @return $this
     */
    public function setEmail(EmailAddress $email): self
    {
        $this->data[self::EMAIL] = [$email];

        return $this;
    }

    /**
     * @param PhoneNumber $phone
     * @return $this
     */
    public function setPhone(PhoneNumber $phone): self
    {
        $this->data[self::PHONE] = [$phone];

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
