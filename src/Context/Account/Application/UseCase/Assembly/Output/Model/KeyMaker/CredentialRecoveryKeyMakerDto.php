<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * Class CredentialRecoveryKeyMakerDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 *
 * @OA\Schema(
 *     allOf={
 *         @OA\Schema(ref=@Model(type=KeyMakerDto::class)),
 *         @OA\Schema(ref=@Model(type=CredentialRecoveryKeyMakerDto::class))
 *     }
 * )
 */
final class CredentialRecoveryKeyMakerDto extends KeyMakerDto
{
    /**
     * @param CredentialRecoveryKeyMaker $keyMaker
     * @return static
     */
    public static function createFromCredentialRecoveryKeyMaker(CredentialRecoveryKeyMaker $keyMaker): self
    {
        return parent::createFromKeyMaker($keyMaker);
    }
}
