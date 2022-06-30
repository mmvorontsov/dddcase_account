<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange;

use DateTimeImmutable;
use InvalidArgumentException;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeStatusEnum;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use OpenApi\Annotations as OA;

/**
 * Class ContactDataChangeDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange
 */
abstract class ContactDataChangeDto
{
    /**
     * @var string
     *
     * @OA\Property(property="contactDataChangeId", format="uuid")
     */
    private string $contactDataChangeId;

    /**
     * @var string
     *
     * @OA\Property(property="status", enum={
     *     ContactDataChangeStatusEnum::SIGNING,
     *     ContactDataChangeStatusEnum::DONE
     * })
     */
    private string $status;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * ContactDataChangeDto constructor.
     * @param string $contactDataChangeId
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    protected function __construct(
        string $contactDataChangeId,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->contactDataChangeId = $contactDataChangeId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param ContactDataChange $contactDataChange
     * @return EmailChangeDto|PhoneChangeDto
     */
    public static function createFromContactDataChange(
        ContactDataChange $contactDataChange
    ): EmailChangeDto|PhoneChangeDto {
        return match (true) {
            $contactDataChange instanceof EmailChange => EmailChangeDto::createFromEmailChange($contactDataChange),
            $contactDataChange instanceof PhoneChange => PhoneChangeDto::createFromPhoneChange($contactDataChange),
            default => throw new InvalidArgumentException('Unexpected contact data change type.'),
        };
    }

    /**
     * @return string
     */
    public function getContactDataChangeId(): string
    {
        return $this->contactDataChangeId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
