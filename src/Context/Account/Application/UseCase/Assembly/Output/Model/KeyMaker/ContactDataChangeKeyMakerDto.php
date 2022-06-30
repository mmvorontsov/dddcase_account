<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class ContactDataChangeKeyMakerDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 *
 * @OA\Schema(
 *     allOf={
 *         @OA\Schema(ref=@Model(type=KeyMakerDto::class)),
 *         @OA\Schema(ref=@Model(type=ContactDataChangeKeyMakerDto::class))
 *     }
 * )
 */
final class ContactDataChangeKeyMakerDto extends KeyMakerDto
{
    /**
     * @param ContactDataChangeKeyMaker $keyMaker
     * @return static
     */
    public static function createFromContactDataChangeKeyMaker(ContactDataChangeKeyMaker $keyMaker): self
    {
        return parent::createFromKeyMaker($keyMaker);
    }
}
