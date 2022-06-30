<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential;

use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\PasswordHistory\PasswordHistory;
use OpenApi\Annotations as OA;

/**
 * Class CredentialDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\Credential
 */
final class CredentialDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $credentialId;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var CredentialPasswordHistoryDto[]
     */
    private array $passwordHistory;

    /**
     * CredentialDto constructor.
     * @param string $credentialId
     * @param string|null $username
     * @param array $passwordHistory
     */
    public function __construct(string $credentialId, ?string $username, array $passwordHistory)
    {
        $this->credentialId = $credentialId;
        $this->username = $username;
        $this->passwordHistory = $passwordHistory;
    }

    /**
     * @param Credential $credential
     * @return CredentialDto
     */
    public static function createFromCredential(Credential $credential): CredentialDto
    {
        return new self(
            $credential->getCredentialId(),
            $credential->getUsername(),
            $credential->getPasswordHistory()
                ->map(
                    static function (PasswordHistory $passwordHistory) {
                        return CredentialPasswordHistoryDto::createFromPasswordHistory($passwordHistory);
                    },
                )
                ->getValues(),
        );
    }

    /**
     * @return string
     */
    public function getCredentialId(): string
    {
        return $this->credentialId;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return CredentialPasswordHistoryDto[]
     */
    public function getPasswordHistory(): array
    {
        return $this->passwordHistory;
    }
}
