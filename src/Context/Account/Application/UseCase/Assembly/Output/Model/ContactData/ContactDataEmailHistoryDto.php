<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData;

use DateTimeImmutable;
use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use OpenApi\Annotations as OA;

/**
 * Class ContactDataEmailHistoryDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData
 */
final class ContactDataEmailHistoryDto
{
    /**
     * @var string|null
     *
     * @OA\Property(property="email", format="email", example="email@example.com")
     */
    private ?string $email;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $replacedAt;

    /**
     * ContactDataEmailHistoryDto constructor.
     * @param string|null $email
     * @param DateTimeImmutable $replacedAt
     */
    public function __construct(?string $email, DateTimeImmutable $replacedAt)
    {
        $this->email = $email;
        $this->replacedAt = $replacedAt;
    }

    /**
     * @param EmailHistory $emailHistory
     * @return static
     */
    public static function createFromEmailHistory(EmailHistory $emailHistory): self
    {
        return new self(
            $emailHistory->getEmail(),
            $emailHistory->getReplacedAt(),
        );
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReplacedAt(): DateTimeImmutable
    {
        return $this->replacedAt;
    }
}
