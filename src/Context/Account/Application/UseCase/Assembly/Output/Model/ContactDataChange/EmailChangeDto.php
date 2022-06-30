<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class EmailChangeDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange
 *
 * @OA\Schema(allOf={
 *     @OA\Schema(ref=@Model(type=ContactDataChangeDto::class)),
 *     @OA\Schema(ref=@Model(type=EmailChangeDto::class))
 * })
 */
final class EmailChangeDto extends ContactDataChangeDto
{
    /**
     * @var string
     *
     * @OA\Property(
     *     example=PrimaryContactDataTypeEnum::EMAIL,
     *     enum={PrimaryContactDataTypeEnum::EMAIL}
     * )
     */
    private string $type;

    /**
     * @var string
     *
     * @OA\Property(format="email")
     */
    private string $toEmail;

    /**
     * EmailChangeDto constructor.
     * @param string $contactDataChangeId
     * @param string $toEmail
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        string $contactDataChangeId,
        string $toEmail,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        parent::__construct($contactDataChangeId, $status, $createdAt, $expiredAt);
        $this->type = PrimaryContactDataTypeEnum::EMAIL;
        $this->toEmail = $toEmail;
    }

    /**
     * @param EmailChange $contactDataChange
     * @return EmailChangeDto
     */
    public static function createFromEmailChange(EmailChange $contactDataChange): EmailChangeDto
    {
        return new self(
            $contactDataChange->getContactDataChangeId()->getValue(),
            $contactDataChange->getToEmail()->getValue(),
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
    public function getToEmail(): string
    {
        return $this->toEmail;
    }
}
