<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use DateTimeImmutable;

/**
 * Class KeyMakerSecretCodeDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 */
final class KeyMakerSecretCodeDto
{
    /**
     * @var int
     */
    private int $acceptanceAttempts;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * KeyMakerSecretCodeDto constructor.
     * @param int $acceptanceAttempts
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        int $acceptanceAttempts,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->acceptanceAttempts = $acceptanceAttempts;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param SecretCode $secretCode
     * @return KeyMakerSecretCodeDto
     */
    public static function createFromSecretCode(SecretCode $secretCode): KeyMakerSecretCodeDto
    {
        return new self(
            $secretCode->getAcceptanceAttempts(),
            $secretCode->getCreatedAt(),
            $secretCode->getExpiredAt(),
        );
    }

    /**
     * @return int
     */
    public function getAcceptanceAttempts(): int
    {
        return $this->acceptanceAttempts;
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
