<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData;

use DateTimeImmutable;
use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use OpenApi\Annotations as OA;

/**
 * Class ContactDataPhoneHistoryDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData
 */
final class ContactDataPhoneHistoryDto
{
    /**
     * @var string|null
     *
     * @OA\Property(property="phone", description="Phone number")
     */
    private ?string $phone;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * ContactDataPhoneHistoryDto constructor.
     * @param string|null $phone
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(?string $phone, DateTimeImmutable $replacedAt)
    {
        $this->phone = $phone;
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param PhoneHistory $phoneHistory
     * @return static
     */
    public static function createFromPhoneHistory(PhoneHistory $phoneHistory): self
    {
        return new self(
            $phoneHistory->getPhone(),
            $phoneHistory->getReplacedAt(),
        );
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
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
