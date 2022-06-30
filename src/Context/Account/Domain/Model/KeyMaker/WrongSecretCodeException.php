<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Throwable;

/**
 * Class WrongSecretCodeException
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
final class WrongSecretCodeException extends DomainException
{
    /**
     * @var KeyMakerId
     */
    private KeyMakerId $keyMakerId;

    /**
     * @var Uuid
     */
    private Uuid $secretCodeUuid;

    /**
     * WrongSecretCodeException constructor.
     * @param KeyMakerId $keyMakerId
     * @param Uuid $secretCodeUuid
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        KeyMakerId $keyMakerId,
        Uuid $secretCodeUuid,
        $message = 'Wrong secret code.',
        Throwable $previous = null,
    ) {
        parent::__construct($message, $previous);
        $this->keyMakerId = $keyMakerId;
        $this->secretCodeUuid = $secretCodeUuid;
    }

    /**
     * @return KeyMakerId
     */
    public function getKeyMakerId(): KeyMakerId
    {
        return $this->keyMakerId;
    }

    /**
     * @return Uuid
     */
    public function getSecretCodeUuid(): Uuid
    {
        return $this->secretCodeUuid;
    }
}
