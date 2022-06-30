<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\Registration;

use DateTimeImmutable;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationStatusEnum;
use OpenApi\Annotations as OA;

/**
 * Class RegistrationDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\Registration
 */
final class RegistrationDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $registrationId;

    /**
     * @var string
     *
     * @OA\Property(enum={
     *     RegistrationStatusEnum::SIGNING,
     *     RegistrationStatusEnum::DONE
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
     * RegistrationDto constructor.
     * @param string $registrationId
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        string $registrationId,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->registrationId = $registrationId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param Registration $registration
     * @return static
     */
    public static function createFromRegistration(Registration $registration): self
    {
        return new self(
            $registration->getRegistrationId()->getValue(),
            $registration->getStatus(),
            $registration->getCreatedAt(),
            $registration->getExpiredAt(),
        );
    }

    /**
     * @return string
     */
    public function getRegistrationId(): string
    {
        return $this->registrationId;
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
