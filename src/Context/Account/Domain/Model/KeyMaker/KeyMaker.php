<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Common\Util\NumberUtil;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Exception;

use function sprintf;

/**
 * Class KeyMaker
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
abstract class KeyMaker implements AggregateRootInterface
{
    protected const SECRET_CODE_FROM = 100000;
    protected const SECRET_CODE_TO = 999999;
    protected const SECRET_CODE_LIFETIME = 180;

    /**
     * @var KeyMakerId
     */
    protected KeyMakerId $keyMakerId;

    /**
     * @var int
     */
    protected int $secretCodesLimit;

    /**
     * Do not send secret codes on the specified transport if true
     * @var bool
     */
    protected bool $isMute;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $expiredAt;

    /**
     * @var Recipient
     */
    protected Recipient $recipient;

    /**
     * @var Collection<string, SecretCode>
     */
    protected Collection $secretCodes;

    /**
     * KeyMaker constructor.
     * @param KeyMakerId $keyMakerId
     * @param int $secretCodesLimit
     * @param bool $isMute
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     * @param Recipient $recipient
     * @param Collection $secretCodes
     */
    protected function __construct(
        KeyMakerId $keyMakerId,
        int $secretCodesLimit,
        bool $isMute,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
        Recipient $recipient,
        Collection $secretCodes,
    ) {
        $this->keyMakerId = $keyMakerId;
        $this->secretCodesLimit = $secretCodesLimit;
        $this->isMute = $isMute;
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
        $this->recipient = $recipient;
        $this->secretCodes = $secretCodes;
    }

    /**
     * @throws Exception
     */
    public function createSecretCode(): void
    {
        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Key maker has expired.');
        }

        if ($this->secretCodes->count() >= $this->secretCodesLimit) {
            throw new DomainException('Maximum number of secret codes reached.');
        }

        if (!$this->secretCodes->isEmpty()) {
            $lastSecretCodeExpiredAt = $this->getLastSecretCode()->getExpiredAt();
            $now = new DateTimeImmutable();
            if ($lastSecretCodeExpiredAt > $now) {
                throw new DomainException(
                    sprintf(
                        'Create a new secret code after %d seconds.',
                        $lastSecretCodeExpiredAt->getTimestamp() - $now->getTimestamp(),
                    ),
                );
            }
        }

        $code = (string)NumberUtil::generate(self::SECRET_CODE_FROM, self::SECRET_CODE_TO);
        $secretCode = SecretCode::create($this, $code, self::SECRET_CODE_LIFETIME);
        $this->secretCodes->set($secretCode->getUuid()->getValue(), $secretCode);

        DomainEventSubject::instance()->notify(
            new KeyMakerSecretCodeAdded($this, $secretCode),
        );
    }

    /**
     * @param string $code
     */
    public function acceptLastSecretCode(string $code): void
    {
        if (new DateTimeImmutable() > $this->expiredAt) {
            throw new DomainException('Key maker has expired.');
        }

        $this->getLastSecretCode()->accept($code);
    }

    /**
     * @param Uuid $secretCodeUuid
     */
    public function registerWrongCodeAcceptanceAttempt(Uuid $secretCodeUuid): void
    {
        /** @var SecretCode|null $secretCode */
        $secretCode = $this->secretCodes
            ->filter(fn(SecretCode $secretCode) => $secretCode->getUuid()->isEqualTo($secretCodeUuid))
            ->first();

        $secretCode?->decreaseAcceptanceAttempts();
    }

    /**
     * @return KeyMakerId
     */
    public function getKeyMakerId(): KeyMakerId
    {
        return $this->keyMakerId;
    }

    /**
     * @return SecretCode
     */
    public function getLastSecretCode(): SecretCode
    {
        return $this->secretCodes->last();
    }

    /**
     * @return int
     */
    public function getSecretCodesLimit(): int
    {
        return $this->secretCodesLimit;
    }

    /**
     * @return bool
     */
    public function getIsMute(): bool
    {
        return $this->isMute;
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

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @return Collection<string, SecretCode>
     */
    public function getSecretCodes(): Collection
    {
        return $this->secretCodes;
    }
}
