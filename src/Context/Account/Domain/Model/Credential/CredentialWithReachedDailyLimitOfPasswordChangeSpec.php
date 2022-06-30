<?php

namespace App\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\Model\Credential\PasswordHistory\PasswordHistory;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class CredentialWithReachedDailyLimitOfPasswordChangeSpec
 * @package App\Context\Account\Domain\Model\Credential
 */
class CredentialWithReachedDailyLimitOfPasswordChangeSpec
{
    /**
     * @param Credential $credential
     * @return bool
     * @throws Exception
     */
    public function isSatisfiedBy(Credential $credential): bool
    {
        if ($credential->getPasswordHistory()->isEmpty()) {
            return false;
        }

        $oneDayAgo = new DateTimeImmutable(sprintf('-%d hours', 24));

        $count = $credential->getPasswordHistory()
            ->filter(fn(PasswordHistory $passwordHistory) => $passwordHistory->getReplacedAt() > $oneDayAgo)
            ->count();

        return $count >= Credential::PASSWORD_CHANGE_DAILY_LIMIT;
    }
}
