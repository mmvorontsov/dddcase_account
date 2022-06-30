<?php

namespace App\Context\Account\Domain\Model\Registration;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class Registration
 * @package App\Context\Account\Domain\Model\Registration
 */
class Registration implements AggregateRootInterface
{
    public const LIFETIME = 3600; // in seconds

    /**
     * @var RegistrationId
     */
    private RegistrationId $registrationId;

    /**
     * @var PersonalData
     */
    private PersonalData $personalData;

    /**
     * @var string
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
     * Registration constructor.
     * @param RegistrationId $registrationId
     * @param PersonalData $personalData
     * @param string $status
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        RegistrationId $registrationId,
        PersonalData $personalData,
        string $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->registrationId = $registrationId;
        $this->personalData = $personalData;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param CreateRegistrationCommand $command
     * @return Registration
     * @throws Exception
     */
    public static function create(CreateRegistrationCommand $command): Registration
    {
        $registration = new self(
            RegistrationId::create(),
            new PersonalData(
                $command->getFirstname(),
                $command->getHashedPassword(),
                $command->getEmail(),
            ),
            RegistrationStatusEnum::SIGNING,
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', self::LIFETIME)),
        );

        DomainEventSubject::instance()->notify(
            new RegistrationCreated($registration),
        );

        return $registration;
    }

    /**
     * @return void
     */
    public function sign(): void
    {
        if (RegistrationStatusEnum::SIGNING !== $this->status) {
            throw new DomainException('Registration has invalid status for signing.');
        }

        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Registration has expired.');
        }

        $this->status = RegistrationStatusEnum::DONE;
    }

    /**
     * @return RegistrationId
     */
    public function getRegistrationId(): RegistrationId
    {
        return $this->registrationId;
    }

    /**
     * @return PersonalData
     */
    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
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
