<?php

namespace App\Context\Account\Domain\Event\Subscriber\ContactDataChange;

use Exception;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataAssertion;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeCreated;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\CreateContactDataChangeKeyMakerCommand;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class ContactDataChangeCreatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\ContactDataChange
 */
final class ContactDataChangeCreatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var ContactDataRepositoryInterface
     */
    private ContactDataRepositoryInterface $contactDataRepository;

    /**
     * @var ContactDataSelectionSpecFactoryInterface
     */
    private ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory;

    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * ContactDataChangeCreatedSubscriber constructor.
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     */
    public function __construct(
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory,
        KeyMakerRepositoryInterface $keyMakerRepository
    ) {
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
        $this->keyMakerRepository = $keyMakerRepository;
    }

    /**
     * @param ContactDataChangeCreated $event
     * @throws Exception
     */
    public function __invoke(ContactDataChangeCreated $event): void
    {
        $this->checkContactDataUniqueness($event);
        $this->checkAvailabilityToChangeContactData($event);
        $this->createContactDataChangeKeyMaker($event);
    }

    /**
     * @param ContactDataChangeCreated $event
     */
    private function checkContactDataUniqueness(ContactDataChangeCreated $event): void
    {
        $contactDataChange = $event->getContactDataChange();

        if ($contactDataChange instanceof EmailChange) {
            $this->checkContactDataEmailUniqueness($contactDataChange->getToEmail());
        }

        if ($contactDataChange instanceof PhoneChange) {
            $this->checkContactDataPhoneUniqueness($contactDataChange->getToPhone());
        }
    }

    /**
     * @param EmailAddress $toEmail
     */
    private function checkContactDataEmailUniqueness(EmailAddress $toEmail): void
    {
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasEmailSelectionSpec($toEmail)
        );

        if (null !== $contactData) {
            throw new UniqueViolationException(
                sprintf('Email %s is already in use.', $toEmail->getValue())
            );
        }
    }

    /**
     * @param PhoneNumber $toPhone
     */
    private function checkContactDataPhoneUniqueness(PhoneNumber $toPhone): void
    {
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasPhoneSelectionSpec($toPhone)
        );

        if (null !== $contactData) {
            throw new UniqueViolationException(
                sprintf('Phone %s is already in use.', $toPhone->getValue())
            );
        }
    }

    /**
     * @param ContactDataChangeCreated $event
     */
    private function checkAvailabilityToChangeContactData(ContactDataChangeCreated $event): void
    {
        $contactDataChange = $event->getContactDataChange();
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createBelongsToUserSelectionSpec($contactDataChange->getUserId())
        );

        if ($contactDataChange instanceof EmailChange) {
            ContactDataAssertion::availableForEmailChange($contactData);
        }

        if ($contactDataChange instanceof PhoneChange) {
            ContactDataAssertion::availableForPhoneChange($contactData);
        }
    }

    /**
     * @param ContactDataChangeCreated $event
     * @throws Exception
     */
    private function createContactDataChangeKeyMaker(ContactDataChangeCreated $event): void
    {
        $contactDataChange = $event->getContactDataChange();

        $contactDataChangeKeyMaker = ContactDataChangeKeyMaker::create(
            new CreateContactDataChangeKeyMakerCommand(
                $contactDataChange->getToValue(),
                $contactDataChange->getContactDataChangeId(),
                $contactDataChange->getExpiredAt(),
            )
        );

        $this->keyMakerRepository->add($contactDataChangeKeyMaker);
    }
}
