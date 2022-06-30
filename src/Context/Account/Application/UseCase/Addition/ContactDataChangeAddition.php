<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeRepositoryInterface;

/**
 * Trait ContactDataChangeAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class ContactDataChangeAddition implements ContactDataChangeAdditionInterface
{
    /**
     * @var ContactDataChangeRepositoryInterface
     */
    private ContactDataChangeRepositoryInterface $contactDataChangeRepository;

    /**
     * ContactDataChangeAddition constructor.
     * @param ContactDataChangeRepositoryInterface $contactDataChangeRepository
     */
    public function __construct(ContactDataChangeRepositoryInterface $contactDataChangeRepository)
    {
        $this->contactDataChangeRepository = $contactDataChangeRepository;
    }

    /**
     * @param ContactDataChangeId $id
     * @return ContactDataChange|null
     */
    public function findById(ContactDataChangeId $id): ?ContactDataChange
    {
        return $this->contactDataChangeRepository->findById($id);
    }

    /**
     * @param ContactDataChangeId $id
     * @param string|null $msg
     * @return ContactDataChange
     */
    public function findByIdOrNotFound(ContactDataChangeId $id, string $msg = null): ContactDataChange
    {
        $contactDataChange = $this->findById($id);
        if (null === $contactDataChange) {
            throw new NotFoundException($msg ?? 'Contact data change not found.');
        }

        return $contactDataChange;
    }
}
