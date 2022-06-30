<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * Class PhoneChangeDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange
 *
 * @OA\Schema(allOf={
 *     @OA\Schema(ref=@Model(type=ContactDataChangeDto::class)),
 *     @OA\Schema(ref=@Model(type=PhoneChangeDto::class))
 * })
 */
final class PhoneChangeDto extends ContactDataChangeDto
{
    /**
     * @var string
     *
     * @OA\Property(
     *     example=PrimaryContactDataTypeEnum::PHONE,
     *     enum={PrimaryContactDataTypeEnum::PHONE}
     * )
     */
    private string $type;

    /**
     * @var string
     *
     * @OA\Property(description="Phone number")
     */
    private string $toPhone;

    /**
     * PhoneChangeDto constructor.
     * @param string $contactDataChangeId
     * @param string $toPhone
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        string $contactDataChangeId,
        string $toPhone,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        parent::__construct($contactDataChangeId, $status, $createdAt, $expiredAt);
        $this->type = PrimaryContactDataTypeEnum::PHONE;
        $this->toPhone = $toPhone;
    }

    /**
     * @param PhoneChange $contactDataChange
     * @return PhoneChangeDto
     */
    public static function createFromPhoneChange(PhoneChange $contactDataChange): PhoneChangeDto
    {
        return new self(
            $contactDataChange->getContactDataChangeId()->getValue(),
            $contactDataChange->getToPhone()->getValue(),
            $contactDataChange->getStatus(),
            $contactDataChange->getCreatedAt(),
            $contactDataChange->getExpiredAt(),
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getToPhone(): string
    {
        return $this->toPhone;
    }
}
