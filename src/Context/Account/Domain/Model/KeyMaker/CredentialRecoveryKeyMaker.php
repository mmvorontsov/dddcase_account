<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;

/**
 * Class CredentialRecoveryKeyMaker
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
class CredentialRecoveryKeyMaker extends KeyMaker
{
    private const SECRET_CODES_LIMIT = 6;

    /**
     * @var CredentialRecoveryId
     */
    private CredentialRecoveryId $credentialRecoveryId;

    /**
     * CredentialRecoveryKeyMaker constructor.
     * @param CredentialRecoveryId $credentialRecoveryId
     * @param KeyMakerId $keyMakerId
     * @param int $secretCodesLimit
     * @param bool $isMute
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     * @param Recipient $recipient
     * @param Collection $secretCodes
     */
    public function __construct(
        CredentialRecoveryId $credentialRecoveryId,
        KeyMakerId $keyMakerId,
        int $secretCodesLimit,
        bool $isMute,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
        Recipient $recipient,
        Collection $secretCodes,
    ) {
        parent::__construct(
            $keyMakerId,
            $secretCodesLimit,
            $isMute,
            $createdAt,
            $expiredAt,
            $recipient,
            $secretCodes,
        );

        $this->credentialRecoveryId = $credentialRecoveryId;
    }

    /**
     * @param CreateCredentialRecoveryKeyMakerCommand $command
     * @return CredentialRecoveryKeyMaker
     * @throws Exception
     */
    public static function create(CreateCredentialRecoveryKeyMakerCommand $command): CredentialRecoveryKeyMaker
    {
        $keyMaker = new self(
            $command->getCredentialRecoveryId(),
            KeyMakerId::create(),
            self::SECRET_CODES_LIMIT,
            $command->getIsMute(),
            new DateTimeImmutable(),
            $command->getExpiredAt(),
            Recipient::create($command->getPrimaryContactData()),
            new ArrayCollection(),
        );

        $keyMaker->createSecretCode();

        return $keyMaker;
    }

    /**
     * @return CredentialRecoveryId
     */
    public function getCredentialRecoveryId(): CredentialRecoveryId
    {
        return $this->credentialRecoveryId;
    }
}
