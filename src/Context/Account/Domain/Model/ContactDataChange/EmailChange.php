<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\User\UserId;

use function sprintf;

/**
 * Class EmailChange
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class EmailChange extends ContactDataChange
{
    private const LIFETIME = 3600;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $fromEmail;

    /**
     * @var EmailAddress
     */
    private EmailAddress $toEmail;

    /**
     * EmailChange constructor.
     * @param UserId $userId
     * @param ContactDataChangeId $contactDataChangeId
     * @param string $status
     * @param EmailAddress|null $fromEmail
     * @param EmailAddress $toEmail
     * @param DateTimeImmutable $createdAt
     * @param DateTimeImmutable $expiredAt
     */
    public function __construct(
        UserId $userId,
        ContactDataChangeId $contactDataChangeId,
        string $status,
        ?EmailAddress $fromEmail,
        EmailAddress $toEmail,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $expiredAt,
    ) {
        parent::__construct(
            $userId,
            $contactDataChangeId,
            $status,
            $createdAt,
            $expiredAt,
        );

        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
    }

    /**
     * @param CreateEmailChangeCommand $command
     * @return EmailChange
     * @throws Exception
     */
    public static function create(CreateEmailChangeCommand $command): EmailChange
    {
        $contactDataChange = new self(
            $command->getUserId(),
            ContactDataChangeId::create(),
            ContactDataChangeStatusEnum::SIGNING,
            $command->getFromEmail(),
            $command->getToEmail(),
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', self::LIFETIME)),
        );

        DomainEventSubject::instance()->notify(
            new ContactDataChangeCreated($contactDataChange),
        );

        return $contactDataChange;
    }

    /**
     * @return EmailAddress|null
     */
    public function getFromEmail(): ?EmailAddress
    {
        return $this->fromEmail;
    }

    /**
     * @return EmailAddress
     */
    public function getToEmail(): EmailAddress
    {
        return $this->toEmail;
    }

    /**
     * @return PrimaryContactData
     */
    public function getToValue(): PrimaryContactData
    {
        return $this->toEmail;
    }
}
