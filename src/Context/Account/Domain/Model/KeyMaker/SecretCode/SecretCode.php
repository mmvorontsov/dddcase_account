<?php

namespace App\Context\Account\Domain\Model\KeyMaker\SecretCode;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Model\KeyMaker\KeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\WrongSecretCodeException;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class SecretCode
 * @package App\Context\Account\Domain\Model\KeyMaker\SecretCode
 */
class SecretCode
{
    private const ACCEPTANCE_ATTEMPTS_LIMIT = 3;

    /**
     * @var KeyMaker
     */
    private KeyMaker $keyMaker;

    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * @var string
     */
    private string $code;

    /**
     * @var string
     */
    private string $status;

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
     * SecretCode constructor.
     * @param KeyMaker $keyMaker
     * @param Uuid $uuid
     * @param string $code
     * @param string $status
     * @param int $acceptanceAttempts
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        KeyMaker $keyMaker,
        Uuid $uuid,
        string $code,
        string $status,
        int $acceptanceAttempts,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt
    ) {
        $this->keyMaker = $keyMaker;
        $this->uuid = $uuid;
        $this->code = $code;
        $this->status = $status;
        $this->acceptanceAttempts = $acceptanceAttempts;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }


    /**
     * @param KeyMaker $keyMaker
     * @param string $code
     * @param int $lifetime
     * @return SecretCode
     * @throws Exception
     */
    public static function create(KeyMaker $keyMaker, string $code, int $lifetime): SecretCode
    {
        return new self(
            $keyMaker,
            Uuid::create(),
            $code,
            SecretCodeEnum::ACCEPTANCE_WAITING,
            self::ACCEPTANCE_ATTEMPTS_LIMIT,
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', $lifetime)),
        );
    }

    /**
     * @param string $code
     */
    public function accept(string $code): void
    {
        if (SecretCodeEnum::ACCEPTANCE_WAITING !== $this->status) {
            throw new DomainException('Secret code has invalid status for acceptance.');
        }

        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Secret code has expired.');
        }

        if ($this->acceptanceAttempts < 1) {
            throw new DomainException('Secret code acceptance attempts ended.');
        }

        if ($code !== $this->code) {
            throw new WrongSecretCodeException($this->keyMaker->getKeyMakerId(), $this->uuid);
        }

        $this->status = SecretCodeEnum::ACCEPTED;
    }

    /**
     * @return void
     */
    public function decreaseAcceptanceAttempts(): void
    {
        // TODO: Change logic
        if ($this->acceptanceAttempts > 0) {
            $this->acceptanceAttempts = $this->acceptanceAttempts - 1;
        }
    }

    /**
     * @return KeyMaker
     */
    public function getKeyMaker(): KeyMaker
    {
        return $this->keyMaker;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
