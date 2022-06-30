<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class RegistrationKeyMaker
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
class RegistrationKeyMaker extends KeyMaker
{
    private const SECRET_CODES_LIMIT = 6;

    /**
     * @var RegistrationId
     */
    private RegistrationId $registrationId;

    /**
     * RegistrationKeyMaker constructor.
     * @param RegistrationId $registrationId
     * @param KeyMakerId $keyMakerId
     * @param int $secretCodesLimit
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     * @param Recipient $recipient
     * @param Collection $secretCodes
     */
    public function __construct(
        RegistrationId $registrationId,
        KeyMakerId $keyMakerId,
        int $secretCodesLimit,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
        Recipient $recipient,
        Collection $secretCodes,
    ) {
        parent::__construct(
            $keyMakerId,
            $secretCodesLimit,
            false,
            $createdAt,
            $expiredAt,
            $recipient,
            $secretCodes,
        );

        $this->registrationId = $registrationId;
    }

    /**
     * @param CreateRegistrationKeyMakerCommand $command
     * @return RegistrationKeyMaker
     * @throws Exception
     */
    public static function create(CreateRegistrationKeyMakerCommand $command): RegistrationKeyMaker
    {
        $keyMaker = new self(
            $command->getRegistrationId(),
            KeyMakerId::create(),
            self::SECRET_CODES_LIMIT,
            new DateTimeImmutable(),
            $command->getExpiredAt(),
            Recipient::create($command->getPrimaryContactData()),
            new ArrayCollection(),
        );

        $keyMaker->createSecretCode();

        return $keyMaker;
    }

    /**
     * @return RegistrationId
     */
    public function getRegistrationId(): RegistrationId
    {
        return $this->registrationId;
    }
}
