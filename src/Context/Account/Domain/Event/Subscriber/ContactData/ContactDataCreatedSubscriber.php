<?php

namespace App\Context\Account\Domain\Event\Subscriber\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataCreated;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class ContactDataCreatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\ContactData
 */
final class ContactDataCreatedSubscriber implements DomainEventSubscriberInterface
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
     * ContactDataCreatedSubscriber constructor.
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     */
    public function __construct(
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
    ) {
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
    }

    /**
     * @param ContactDataCreated $event
     */
    public function __invoke(ContactDataCreated $event): void
    {
        $this->checkContactDataUniqueness($event);
    }

    /**
     * @param ContactDataCreated $event
     */
    private function checkContactDataUniqueness(ContactDataCreated $event): void
    {
        $email = $event->getContactData()->getEmail();
        $phone = $event->getContactData()->getPhone();

        if (null !== $email) {
            $this->checkContactDataEmailUniqueness($email);
        }

        if (null !== $phone) {
            $this->checkContactDataPhoneUniqueness($phone);
        }
    }

    /**
     * @param EmailAddress $email
     */
    private function checkContactDataEmailUniqueness(EmailAddress $email): void
    {
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasEmailSelectionSpec($email)
        );

        if (null !== $contactData) {
            throw new UniqueViolationException(
                sprintf('Email %s is already in use.', $email->getValue())
            );
        }
    }

    /**
     * @param PhoneNumber $phone
     */
    private function checkContactDataPhoneUniqueness(PhoneNumber $phone): void
    {
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasPhoneSelectionSpec($phone)
        );

        if (null !== $contactData) {
            throw new UniqueViolationException(
                sprintf('Phone %s is already in use.', $phone->getValue())
            );
        }
    }
}
