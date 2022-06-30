<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataId;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Trait ContactDataAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class ContactDataAddition implements ContactDataAdditionInterface
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
     * ContactDataAddition constructor.
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     */
    public function __construct(
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory,
    ) {
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
    }

    /**
     * @param ContactDataId $id
     * @return ContactData|null
     */
    public function findById(ContactDataId $id): ?ContactData
    {
        return $this->contactDataRepository->findById($id);
    }

    /**
     * @param ContactDataId $id
     * @param string|null $msg
     * @return ContactData
     */
    public function findByIdOrNotFound(ContactDataId $id, string $msg = null): ContactData
    {
        $contactData = $this->findById($id);
        if (null === $contactData) {
            throw new NotFoundException($msg ?? 'Contact data not found.');
        }

        return $contactData;
    }

    /**
     * @param UserId $id
     * @return ContactData|null
     */
    public function findContactDataOfUser(UserId $id): ?ContactData
    {
        return $this->contactDataRepository->selectOneSatisfying(
            $this->contactDataSelectionSpecFactory->createBelongsToUserSelectionSpec($id),
        );
    }

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return ContactData
     */
    public function findContactDataOfUserOrNotFound(UserId $id, string $msg = null): ContactData
    {
        $contactData = $this->findContactDataOfUser($id);
        if (null === $contactData) {
            throw new NotFoundException($msg ?? 'Contact data not found.');
        }

        return $contactData;
    }
}
