<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange\ContactDataChangeDto;
use App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange\EmailChangeDto;
use App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange\PhoneChangeDto;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use OpenApi\Annotations as OA;

/**
 * Class CreateContactDataChangeResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
class CreateContactDataChangeResponse
{
    /**
     * @var EmailChangeDto|PhoneChangeDto
     *
     * @OA\Property(
     *     property="item",
     *     example={
     *         "type": "EMAIL",
     *         "toEmail": "email@example.com",
     *         "contactDataChangeId": "fb4934b9-9432-4601-ae22-0d9307771a53",
     *         "status": "SIGNING",
     *         "createdAt": "2021-10-01T04:03:20+00:00",
     *         "expiredAt": "2021-10-01T06:03:20+00:00"
     *     }
     * )
     */
    private EmailChangeDto|PhoneChangeDto $item;

    /**
     * CreateContactDataChangeResponse constructor.
     * @param ContactDataChange $contactDataChange
     */
    public function __construct(ContactDataChange $contactDataChange)
    {
        $this->item = ContactDataChangeDto::createFromContactDataChange($contactDataChange);
    }

    /**
     * @return EmailChangeDto|PhoneChangeDto
     */
    public function getItem(): EmailChangeDto|PhoneChangeDto
    {
        return $this->item;
    }
}
