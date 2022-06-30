<?php

namespace App\Context\Account\Domain\Event\Subscriber\ContactData;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataEmailUpdated;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataPhoneUpdated;
use App\Context\Account\Domain\UniqueViolationException;

use function sprintf;

/**
 * Class ContactDataPhoneUpdatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\ContactData
 */
final class ContactDataPhoneUpdatedSubscriber implements DomainEventSubscriberInterface
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
     * ContactDataPhoneUpdatedSubscriber constructor.
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
     * @param ContactDataPhoneUpdated $event
     */
    public function __invoke(ContactDataPhoneUpdated $event): void
    {
        $this->checkContactDataPhoneUniqueness($event);
    }

    /**
     * @param ContactDataPhoneUpdated $event
     */
    private function checkContactDataPhoneUniqueness(ContactDataPhoneUpdated $event): void
    {
        $contactDataId = $event->getContactData()->getContactDataId();
        $phone = $event->getContactData()->getPhone();

        if (null === $phone) {
            return;
        }

        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasPhoneSelectionSpec($phone)
        );

        if (null !== $contactData && $contactData->getContactDataId()->isEqualTo($contactDataId)) {
            throw new UniqueViolationException(
                sprintf('Phone %s is already in use.', $phone->getValue())
            );
        }
    }
}
