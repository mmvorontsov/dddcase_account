<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class RegistrationKeyMakerDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 *
 * @OA\Schema(
 *     allOf={
 *         @OA\Schema(ref=@Model(type=KeyMakerDto::class)),
 *         @OA\Schema(ref=@Model(type=RegistrationKeyMakerDto::class))
 *     }
 * )
 */
final class RegistrationKeyMakerDto extends KeyMakerDto
{
    /**
     * @param RegistrationKeyMaker $keyMaker
     * @return static
     */
    public static function createFromRegistrationKeyMaker(RegistrationKeyMaker $keyMaker): self
    {
        return self::createFromKeyMaker($keyMaker);
    }
}
