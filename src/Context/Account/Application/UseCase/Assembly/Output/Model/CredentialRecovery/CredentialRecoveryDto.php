<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\CredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryStatusEnum;
use OpenApi\Annotations as OA;

/**
 * Class CredentialRecoveryDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\CredentialRecovery
 */
final class CredentialRecoveryDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $credentialRecoveryId;

    /**
     * @var string
     *
     * @OA\Property(enum={
     *     CredentialRecoveryStatusEnum::SIGNING,
     *     CredentialRecoveryStatusEnum::PASSWORD_ENTRY,
     *     CredentialRecoveryStatusEnum::DONE
     * })
     */
    private string $status;

    /**
     * @var string|null
     */
    private ?string $passwordEntryCode;

    /**
     * CredentialRecoveryDto constructor.
     * @param string $credentialRecoveryId
     * @param string $status
     * @param string|null $passwordEntryCode
     */
    public function __construct(string $credentialRecoveryId, string $status, ?string $passwordEntryCode)
    {
        $this->credentialRecoveryId = $credentialRecoveryId;
        $this->status = $status;
        $this->passwordEntryCode = $passwordEntryCode;
    }

    /**
     * @param CredentialRecovery $credentialRecovery
     * @return CredentialRecoveryDto
     */
    public static function createFromCredentialRecovery(CredentialRecovery $credentialRecovery): CredentialRecoveryDto
    {
        return new self(
            $credentialRecovery->getCredentialRecoveryId(),
            $credentialRecovery->getStatus(),
            $credentialRecovery->getPasswordEntryCode(),
        );
    }

    /**
     * @return string
     */
    public function getCredentialRecoveryId(): string
    {
        return $this->credentialRecoveryId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getPasswordEntryCode(): ?string
    {
        return $this->passwordEntryCode;
    }
}
