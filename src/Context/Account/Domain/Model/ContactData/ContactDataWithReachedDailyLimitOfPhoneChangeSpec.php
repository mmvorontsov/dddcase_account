<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use DateTimeImmutable;
use Exception;

use function sprintf;

/**
 * Class ContactDataWithReachedDailyLimitOfPhoneChangeSpec
 * @package App\Context\Account\Domain\Model\ContactData
 */
class ContactDataWithReachedDailyLimitOfPhoneChangeSpec
{
    /**
     * @param ContactData $contactData
     * @return bool
     * @throws Exception
     */
    public function isSatisfiedBy(ContactData $contactData): bool
    {
        if ($contactData->getPhoneHistory()->isEmpty()) {
            return false;
        }

        $oneDayAgo = new DateTimeImmutable(sprintf('-%d hours', 24));

        $count = $contactData->getPhoneHistory()
            ->filter(fn(PhoneHistory $phoneHistory) => $phoneHistory->getReplacedAt() > $oneDayAgo)
            ->count();

        return $count >= ContactData::PHONE_CHANGE_DAILY_LIMIT;
    }
}
