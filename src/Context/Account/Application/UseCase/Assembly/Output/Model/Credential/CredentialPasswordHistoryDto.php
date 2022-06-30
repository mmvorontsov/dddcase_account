<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential;

use DateTimeImmutable;
use App\Context\Account\Domain\Model\Credential\PasswordHistory\PasswordHistory;

/**
 * Class CredentialPasswordHistoryDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential
 */
final class CredentialPasswordHistoryDto
{
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * CredentialPasswordHistoryDto constructor.
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(DateTimeImmutable $replacedAt)
    {
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param PasswordHistory $passwordHistory
     * @return CredentialPasswordHistoryDto
     */
    public static function createFromPasswordHistory(PasswordHistory $passwordHistory): CredentialPasswordHistoryDto
    {
        return new self(
            $passwordHistory->getReplacedAt(),
        );
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReplacedAt(): DateTimeImmutable
    {
        return $this->replacedAt;
    }
}
