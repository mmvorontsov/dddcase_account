<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;

/**
 * Class ContactDataChangeKeyMaker
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
class ContactDataChangeKeyMaker extends KeyMaker
{
    private const SECRET_CODES_LIMIT = 10;

    /**
     * @var ContactDataChangeId
     */
    private ContactDataChangeId $contactDataChangeId;

    /**
     * ContactDataChangeKeyMaker constructor.
     * @param ContactDataChangeId $contactDataChangeId
     * @param KeyMakerId $keyMakerId
     * @param int $secretCodesLimit
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     * @param Recipient $recipient
     * @param Collection $secretCodes
     */
    public function __construct(
        ContactDataChangeId $contactDataChangeId,
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

        $this->contactDataChangeId = $contactDataChangeId;
    }

    /**
     * @param CreateContactDataChangeKeyMakerCommand $command
     * @return ContactDataChangeKeyMaker
     * @throws Exception
     */
    public static function create(CreateContactDataChangeKeyMakerCommand $command): ContactDataChangeKeyMaker
    {
        $keyMaker = new self(
            $command->getContactDataChangeId(),
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
     * @return ContactDataChangeId
     */
    public function getContactDataChangeId(): ContactDataChangeId
    {
        return $this->contactDataChangeId;
    }
}
