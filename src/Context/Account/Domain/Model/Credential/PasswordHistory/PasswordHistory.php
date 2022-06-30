<?php

namespace App\Context\Account\Domain\Model\Credential\PasswordHistory;

use App\Context\Account\Domain\Common\Type\Uuid;
use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Model\Credential\Credential;

/**
 * Class PasswordHistory
 * @package App\Context\Account\Domain\Model\Credential\PasswordHistory
 */
final class PasswordHistory
{
    /**
     * @var Credential
     */
    protected Credential $credential;

    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * @var string
     */
    private string $hashedPassword;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * PasswordHistory constructor.
     * @param Credential $credential
     * @param Uuid $uuid
     * @param string $hashedPassword
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(
        Credential $credential,
        Uuid $uuid,
        string $hashedPassword,
        DateTimeImmutable $replacedAt
    ) {
        $this->credential = $credential;
        $this->uuid = $uuid;
        $this->hashedPassword = $hashedPassword;
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param Credential $credential
     * @param string $hashedPassword
     * @return PasswordHistory
     * @throws Exception
     */
    public static function create(Credential $credential, string $hashedPassword): PasswordHistory
    {
        return new self(
            $credential,
            Uuid::create(),
            $hashedPassword,
            new DateTimeImmutable(),
        );
    }

    /**
     * @return Credential
     */
    public function getCredential(): Credential
    {
        return $this->credential;
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
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReplacedAt(): DateTimeImmutable
    {
        return $this->replacedAt;
    }
}
