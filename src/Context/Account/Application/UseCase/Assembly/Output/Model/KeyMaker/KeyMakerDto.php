<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\KeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use DateTimeImmutable;

/**
 * Class KeyMakerDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 */
abstract class KeyMakerDto
{
    /**
     * @var KeyMakerRecipientDto
     */
    private KeyMakerRecipientDto $recipient;

    /**
     * @var KeyMakerSecretCodeDto[]
     */
    private array $secretCodes;

    /**
     * @var int
     */
    private int $secretCodesLimit;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $expiredAt;

    /**
     * KeyMakerDto constructor.
     * @param KeyMakerRecipientDto $recipient
     * @param KeyMakerSecretCodeDto[] $secretCodes
     * @param int $secretCodesLimit
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    protected function __construct(
        KeyMakerRecipientDto $recipient,
        array $secretCodes,
        int $secretCodesLimit,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        $this->recipient = $recipient;
        $this->secretCodes = $secretCodes;
        $this->secretCodesLimit = $secretCodesLimit;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param KeyMaker $keyMaker
     * @return static
     */
    protected static function createFromKeyMaker(KeyMaker $keyMaker): self
    {
        return new static(
            KeyMakerRecipientDto::createFromRecipient($keyMaker->getRecipient()),
            $keyMaker->getSecretCodes()
                ->map(
                    static function (SecretCode $secretCode) {
                        return KeyMakerSecretCodeDto::createFromSecretCode($secretCode);
                    },
                )
                ->getValues(),
            $keyMaker->getSecretCodesLimit(),
            $keyMaker->getCreatedAt(),
            $keyMaker->getExpiredAt(),
        );
    }

    /**
     * @return KeyMakerSecretCodeDto[]
     */
    public function getSecretCodes(): array
    {
        return $this->secretCodes;
    }

    /**
     * @return int
     */
    public function getSecretCodesLimit(): int
    {
        return $this->secretCodesLimit;
    }

    /**
     * @return KeyMakerRecipientDto
     */
    public function getRecipient(): KeyMakerRecipientDto
    {
        return $this->recipient;
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
