<?php

namespace App\Context\Account\Domain\Event\Subscriber\Registration;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\CreateRegistrationKeyMakerCommand;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\Registration\RegistrationCreated;
use App\Context\Account\Domain\UniqueViolationException;
use Exception;

use function sprintf;

/**
 * Class RegistrationCreatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\Registration
 */
final class RegistrationCreatedSubscriber implements DomainEventSubscriberInterface
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
     * RegistrationCreatedSubscriber constructor.
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     */
    public function __construct(
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory,
        KeyMakerRepositoryInterface $keyMakerRepository,
    ) {
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
        $this->keyMakerRepository = $keyMakerRepository;
    }

    /**
     * @param RegistrationCreated $event
     * @throws Exception
     */
    public function __invoke(RegistrationCreated $event): void
    {
        $this->checkPersonalDataUniqueness($event);
        $this->createRegistrationKeyMaker($event);
    }

    /**
     * @param RegistrationCreated $event
     */
    private function checkPersonalDataUniqueness(RegistrationCreated $event): void
    {
        $email = $event->getRegistration()->getPersonalData()->getEmail();

        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createHasEmailSelectionSpec($email),
        );

        if (null !== $contactData) {
            throw new UniqueViolationException(
                sprintf('Email %s is already in use.', $email->getValue()),
            );
        }
    }

    /**
     * @param RegistrationCreated $event
     * @throws Exception
     */
    private function createRegistrationKeyMaker(RegistrationCreated $event): void
    {
        $registration = $event->getRegistration();

        $registrationKeyMaker = RegistrationKeyMaker::create(
            new CreateRegistrationKeyMakerCommand(
                $registration->getPersonalData()->getEmail(),
                $registration->getRegistrationId(),
                $registration->getExpiredAt(),
            ),
        );

        $this->keyMakerRepository->add($registrationKeyMaker);
    }
}
