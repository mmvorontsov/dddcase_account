<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker;

use InvalidArgumentException;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\KeyMaker\Recipient;
use OpenApi\Annotations as OA;

/**
 * Class KeyMakerRecipientDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker
 */
final class KeyMakerRecipientDto
{
    /**
     * @var string
     *
     * @OA\Property(
     *     property="type",
     *     enum={
     *         PrimaryContactDataTypeEnum::EMAIL,
     *         PrimaryContactDataTypeEnum::PHONE
     *     }
     * )
     */
    private string $type;

    /**
     * KeyMakerRecipientDto constructor.
     * @param string $type
     */
    protected function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param Recipient $recipient
     * @return KeyMakerRecipientDto
     */
    public static function createFromRecipient(Recipient $recipient): KeyMakerRecipientDto
    {
        $primaryContactData = $recipient->getPrimaryContactData();

        return match (true) {
            $primaryContactData instanceof EmailAddress => new self(PrimaryContactDataTypeEnum::EMAIL),
            $primaryContactData instanceof PhoneNumber => new self(PrimaryContactDataTypeEnum::PHONE),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected primary contact data type %s.', $primaryContactData::class),
            ),
        };
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
