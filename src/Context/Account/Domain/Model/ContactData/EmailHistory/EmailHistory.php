<?php

namespace App\Context\Account\Domain\Model\ContactData\EmailHistory;

use App\Context\Account\Domain\Common\Type\Uuid;
use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class EmailHistory
 * @package App\Context\Account\Domain\Model\ContactData\EmailHistory
 */
final class EmailHistory
{
    /**
     * @var ContactData
     */
    protected ContactData $contactData;

    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $email;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * EmailHistory constructor.
     * @param ContactData $contactData
     * @param Uuid $uuid
     * @param EmailAddress|null $email
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(
        ContactData $contactData,
        Uuid $uuid,
        ?EmailAddress $email,
        DateTimeImmutable $replacedAt,
    ) {
        $this->contactData = $contactData;
        $this->uuid = $uuid;
        $this->email = $email;
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param ContactData $contactData
     * @param EmailAddress|null $email
     * @return EmailHistory
     * @throws Exception
     */
    public static function create(ContactData $contactData, ?EmailAddress $email): EmailHistory
    {
        return new self(
            $contactData,
            Uuid::create(),
            $email,
            new DateTimeImmutable(),
        );
    }

    /**
     * @return ContactData
     */
    public function getContactData(): ContactData
    {
        return $this->contactData;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return EmailAddress|null
     */
    public function getEmail(): ?EmailAddress
    {
        return $this->email;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReplacedAt(): DateTimeImmutable
    {
        return $this->replacedAt;
    }
}
