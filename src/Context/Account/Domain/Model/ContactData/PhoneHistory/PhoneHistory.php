<?php

namespace App\Context\Account\Domain\Model\ContactData\PhoneHistory;

use App\Context\Account\Domain\Common\Type\Uuid;
use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class PhoneHistory
 * @package App\Context\Account\Domain\Model\ContactData\PhoneHistory
 */
final class PhoneHistory
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
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $phone;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * PhoneHistory constructor.
     * @param ContactData $contactData
     * @param Uuid $uuid
     * @param PhoneNumber|null $phone
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(
        ContactData $contactData,
        Uuid $uuid,
        ?PhoneNumber $phone,
        DateTimeImmutable $replacedAt,
    ) {
        $this->contactData = $contactData;
        $this->uuid = $uuid;
        $this->phone = $phone;
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param ContactData $contactData
     * @param PhoneNumber|null $phone
     * @return PhoneHistory
     * @throws Exception
     */
    public static function create(ContactData $contactData, ?PhoneNumber $phone): PhoneHistory
    {
        return new self(
            $contactData,
            Uuid::create(),
            $phone,
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
     * @return PhoneNumber|null
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReplacedAt(): DateTimeImmutable
    {
        return $this->replacedAt;
    }
}
