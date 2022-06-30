<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData;

use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use OpenApi\Annotations as OA;

/**
 * Class ContactDataDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData
 */
final class ContactDataDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $contactDataId;

    /**
     * @var string|null
     *
     * @OA\Property(format="email")
     */
    private ?string $email;

    /**
     * @var string|null
     *
     * @OA\Property(description="Phone number")
     */
    private ?string $phone;

    /**
     * @var ContactDataEmailHistoryDto[]
     */
    private array $emailHistory;

    /**
     * @var ContactDataPhoneHistoryDto[]
     */
    private array $phoneHistory;

    /**
     * ContactDataDto constructor.
     * @param string $contactDataId
     * @param string|null $email
     * @param string|null $phone
     * @param ContactDataEmailHistoryDto[] $emailHistory
     * @param ContactDataPhoneHistoryDto[] $phoneHistory
     */
    public function __construct(
        string $contactDataId,
        ?string $email,
        ?string $phone,
        array $emailHistory,
        array $phoneHistory,
    ) {
        $this->contactDataId = $contactDataId;
        $this->email = $email;
        $this->phone = $phone;
        $this->emailHistory = $emailHistory;
        $this->phoneHistory = $phoneHistory;
    }


    /**
     * @param ContactData $contactData
     * @return ContactDataDto
     */
    public static function createFromContactData(ContactData $contactData): ContactDataDto
    {
        return new self(
            $contactData->getContactDataId()->getValue(),
            $contactData->getEmail(),
            $contactData->getPhone(),
            $contactData->getEmailHistory()
                ->map(
                    static function (EmailHistory $emailHistory) {
                        return ContactDataEmailHistoryDto::createFromEmailHistory($emailHistory);
                    },
                )
                ->getValues(),
            $contactData->getPhoneHistory()
                ->map(
                    static function (PhoneHistory $phoneHistory) {
                        return ContactDataPhoneHistoryDto::createFromPhoneHistory($phoneHistory);
                    },
                )
                ->getValues(),
        );
    }

    /**
     * @return string
     */
    public function getContactDataId(): string
    {
        return $this->contactDataId;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return EmailHistory[]
     */
    public function getEmailHistory(): array
    {
        return $this->emailHistory;
    }

    /**
     * @return PhoneHistory[]
     */
    public function getPhoneHistory(): array
    {
        return $this->phoneHistory;
    }
}
