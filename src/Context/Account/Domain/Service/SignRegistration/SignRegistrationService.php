<?php

namespace App\Context\Account\Domain\Service\SignRegistration;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\CreateContactDataCommand;
use App\Context\Account\Domain\Model\Credential\CreateCredentialCommand;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\Sign\RegistrationSigned;
use App\Context\Account\Domain\Model\User\CreateUserCommand;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;
use Exception;

/**
 * Class SignRegistrationService
 * @package App\Context\Account\Domain\Service\SignRegistration
 */
final class SignRegistrationService implements SignRegistrationServiceInterface
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
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var CredentialRepositoryInterface
     */
    private CredentialRepositoryInterface $credentialRepository;

    /**
     * @var ContactDataRepositoryInterface
     */
    private ContactDataRepositoryInterface $contactDataRepository;

    /**
     * SignRegistrationService constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     * @param UserRepositoryInterface $userRepository
     * @param CredentialRepositoryInterface $credentialRepository
     * @param ContactDataRepositoryInterface $contactDataRepository
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
        UserRepositoryInterface $userRepository,
        CredentialRepositoryInterface $credentialRepository,
        ContactDataRepositoryInterface $contactDataRepository,
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
        $this->userRepository = $userRepository;
        $this->credentialRepository = $credentialRepository;
        $this->contactDataRepository = $contactDataRepository;
    }

    /**
     * @param SignRegistrationCommand $command
     * @return Registration
     * @throws Exception
     */
    public function execute(SignRegistrationCommand $command): Registration
    {
        $registration = $command->getRegistration();
        $registration->sign();

        $keyMaker = $this->findRegistrationKeyMaker($registration->getRegistrationId());
        $keyMaker->acceptLastSecretCode($command->getSecretCode());

        $user = $this->createUser($registration, $command->getRoleIds());
        $this->createCredential($user, $registration->getPersonalData()->getHashedPassword());
        $this->createContactData($user, $registration->getPersonalData()->getEmail());

        DomainEventSubject::instance()->notify(
            new RegistrationSigned($registration),
        );

        return $registration;
    }

    /**
     * @param Registration $registration
     * @param array $roleIds
     * @return User
     * @throws Exception
     */
    private function createUser(Registration $registration, array $roleIds): User
    {
        $personalData = $registration->getPersonalData();
        $user = User::create(new CreateUserCommand($personalData->getFirstname(), $roleIds));
        $this->userRepository->add($user);

        return $user;
    }

    /**
     * @param User $user
     * @param string $hashedPassword
     * @return void
     * @throws Exception
     */
    private function createCredential(User $user, string $hashedPassword): void
    {
        $command = new CreateCredentialCommand($user->getUserId(), null, $hashedPassword);
        $credential = Credential::create($command);
        $this->credentialRepository->add($credential);
    }

    /**
     * @param User $user
     * @param EmailAddress $email
     * @throws Exception
     */
    private function createContactData(User $user, EmailAddress $email): void
    {
        $command = new CreateContactDataCommand($user->getUserId(), $email, null);
        $contactData = ContactData::create($command);
        $this->contactDataRepository->add($contactData);
    }

    /**
     * @param RegistrationId $registrationId
     * @return RegistrationKeyMaker
     */
    private function findRegistrationKeyMaker(RegistrationId $registrationId): RegistrationKeyMaker
    {
        /** @var RegistrationKeyMaker|null $registrationKeyMaker */
        $registrationKeyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToRegistrationSelectionSpec($registrationId),
        );

        if (null === $registrationKeyMaker) {
            throw new DomainException('Registration key maker not found.');
        }

        return $registrationKeyMaker;
    }
}
