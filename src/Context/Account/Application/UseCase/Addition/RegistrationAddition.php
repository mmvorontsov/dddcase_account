<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;

/**
 * Class RegistrationAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class RegistrationAddition implements RegistrationAdditionInterface
{
    /**
     * @var RegistrationRepositoryInterface
     */
    private RegistrationRepositoryInterface $registrationRepository;

    /**
     * RegistrationAddition constructor.
     * @param RegistrationRepositoryInterface $registrationRepository
     */
    public function __construct(RegistrationRepositoryInterface $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * @param RegistrationId $id
     * @return bool
     */
    public function repositoryContainsId(RegistrationId $id): bool
    {
        return $this->registrationRepository->containsId($id);
    }

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return bool
     */
    public function repositoryContainsIdOrNotFound(RegistrationId $id, string $msg = null): bool
    {
        if (!$this->repositoryContainsId($id)) {
            throw new NotFoundException($msg ?? 'Registration data not found.');
        }

        return true;
    }

    /**
     * @param RegistrationId $id
     * @return Registration|null
     */
    public function findById(RegistrationId $id): ?Registration
    {
        return $this->registrationRepository->findById($id);
    }

    /**
     * @param RegistrationId $id
     * @param string|null $msg
     * @return Registration
     */
    public function findByIdOrNotFound(RegistrationId $id, string $msg = null): Registration
    {
        $registration = $this->findById($id);
        if (null === $registration) {
            throw new NotFoundException($msg ?? 'Registration data not found.');
        }

        return $registration;
    }
}
