<?php

namespace App\Context\Account\Domain\Service\SignContactDataChange;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactData\Update\UpdateContactDataCommand;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use App\Context\Account\Domain\Model\ContactDataChange\Sign\ContactDataChangeSigned;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\User\UserId;
use Exception;
use InvalidArgumentException;

use function sprintf;

/**
 * Class SignContactDataChangeService
 * @package App\Context\Account\Domain\Service\SignContactDataChange
 */
final class SignContactDataChangeService implements SignContactDataChangeServiceInterface
{
    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * @var KeyMakerSelectionSpecFactoryInterface
     */
    private KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory;

    /**
     * @var ContactDataRepositoryInterface
     */
    private ContactDataRepositoryInterface $contactDataRepository;

    /**
     * @var ContactDataSelectionSpecFactoryInterface
     */
    private ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory;

    /**
     * SignContactDataChangeService constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory,
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
    }

    /**
     * @param SignContactDataChangeCommand $command
     * @return ContactDataChange
     * @throws Exception
     */
    public function execute(SignContactDataChangeCommand $command): ContactDataChange
    {
        $contactDataChange = $command->getContactDataChange();
        $contactDataChange->sign();

        $keyMaker = $this->findContactDataChangeKeyMaker($contactDataChange->getContactDataChangeId());
        $keyMaker->acceptLastSecretCode($command->getSecretCode());

        $contactData = $this->findUserContactData($contactDataChange->getUserId());
        $updateCommand = $this->createUpdateContactDataCommand($contactDataChange);
        $contactData->update($updateCommand);

        DomainEventSubject::instance()->notify(
            new ContactDataChangeSigned($contactDataChange),
        );

        return $contactDataChange;
    }

    /**
     * @param ContactDataChangeId $contactDataChangeId
     * @return ContactDataChangeKeyMaker
     */
    private function findContactDataChangeKeyMaker(ContactDataChangeId $contactDataChangeId): ContactDataChangeKeyMaker
    {
        /** @var ContactDataChangeKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToContactDataChangeSelectionSpec($contactDataChangeId),
        );

        if (null === $keyMaker) {
            throw new DomainException('Contact data change key maker not found.');
        }

        return $keyMaker;
    }

    /**
     * @param UserId $userId
     * @return ContactData
     */
    private function findUserContactData(UserId $userId): ContactData
    {
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createBelongsToUserSelectionSpec($userId),
        );

        if (null === $contactData) {
            throw new DomainException('Contact data not found.');
        }

        return $contactData;
    }

    /**
     * @param ContactDataChange $contactDataChange
     * @return UpdateContactDataCommand
     */
    private function createUpdateContactDataCommand(ContactDataChange $contactDataChange): UpdateContactDataCommand
    {
        $updateCommand = new UpdateContactDataCommand();

        return match (true) {
            $contactDataChange instanceof EmailChange => $updateCommand->setEmail(
                $contactDataChange->getToEmail(),
            ),
            $contactDataChange instanceof PhoneChange => $updateCommand->setPhone(
                $contactDataChange->getToPhone(),
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected contact data change type %s.', $contactDataChange::class),
            ),
        };
    }
}
