<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class ContactDataWithReachedDailyLimitOfEmailChangeSpec
 * @package App\Context\Account\Domain\Model\ContactData
 */
class ContactDataWithReachedDailyLimitOfEmailChangeSpec
{
    /**
     * @param ContactData $contactData
     * @return bool
     * @throws Exception
     */
    public function isSatisfiedBy(ContactData $contactData): bool
    {
        if ($contactData->getEmailHistory()->isEmpty()) {
            return false;
        }

        $oneDayAgo = new DateTimeImmutable(sprintf('-%d hours', 24));

        $count = $contactData->getEmailHistory()
            ->filter(fn(EmailHistory $phoneHistory) => $phoneHistory->getReplacedAt() > $oneDayAgo)
            ->count();

        return $count >= ContactData::EMAIL_CHANGE_DAILY_LIMIT;
    }
}
