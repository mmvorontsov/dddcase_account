<?php

namespace App\Context\Account\Domain\Event\Subscriber\ContactData;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataEmailUpdated;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class ContactDataEmailUpdatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\ContactData
 */
final class ContactDataEmailUpdatedSubscriber implements DomainEventSubscriberInterface
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
     * ContactDataEmailUpdatedSubscriber constructor.
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
     * @param ContactDataEmailUpdated $event
     */
    public function __invoke(ContactDataEmailUpdated $event): void
    {
        $this->checkContactDataEmailUniqueness($event);
    }

    /**
     * @param ContactDataEmailUpdated $event
     */
    private function checkContactDataEmailUniqueness(ContactDataEmailUpdated $event): void
    {
        $contactDataId = $event->getContactData()->getContactDataId();
        $email = $event->getContactData()->getEmail();

        if (null === $email) {
            return;
        }

        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasEmailSelectionSpec($email)
        );

        if (null !== $contactData && $contactData->getContactDataId()->isEqualTo($contactDataId)) {
            throw new UniqueViolationException(
                sprintf('Email %s is already in use.', $email->getValue())
            );
        }
    }
}
