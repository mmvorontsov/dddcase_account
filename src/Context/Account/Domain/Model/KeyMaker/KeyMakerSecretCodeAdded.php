<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class KeyMakerSecretCodeAdded
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
final class KeyMakerSecretCodeAdded extends DomainEvent
{
    /**
     * @var KeyMaker
     */
    private KeyMaker $keyMaker;

    /**
     * @var SecretCode
     */
    private SecretCode $secretCode;

    /**
     * KeyMakerSecretCodeAdded constructor.
     * @param KeyMaker $keyMaker
     * @param SecretCode $secretCode
     * @throws Exception
     */
    public function __construct(KeyMaker $keyMaker, SecretCode $secretCode)
    {
        parent::__construct();
        $this->keyMaker = $keyMaker;
        $this->secretCode = $secretCode;
    }

    /**
     * @return KeyMaker
     */
    public function getKeyMaker(): KeyMaker
    {
        return $this->keyMaker;
    }

    /**
     * @return SecretCode
     */
    public function getSecretCode(): SecretCode
    {
        return $this->secretCode;
    }
}
