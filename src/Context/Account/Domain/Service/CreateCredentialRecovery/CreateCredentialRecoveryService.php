<?php

namespace App\Context\Account\Domain\Service\CreateCredentialRecovery;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecInterface;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryRepositoryInterface;
use Exception;
use InvalidArgumentException;

use function sprintf;

/**
 * Class CreateCredentialRecoveryService
 * @package App\Context\Account\Domain\Service\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryService implements CreateCredentialRecoveryServiceInterface
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
     * @var CredentialRecoveryRepositoryInterface
     */
    private CredentialRecoveryRepositoryInterface $credentialRecoveryRepository;

    /**
     * CreateCredentialRecoveryService constructor.
     * @param ContactDataRepositoryInterface $contactDataRepository
     * @param ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory
     * @param CredentialRecoveryRepositoryInterface $credentialRecoveryRepository
     */
    public function __construct(
        ContactDataRepositoryInterface $contactDataRepository,
        ContactDataSelectionSpecFactoryInterface $contactDataSelectionSpecFactory,
        CredentialRecoveryRepositoryInterface $credentialRecoveryRepository,
    ) {
        $this->contactDataRepository = $contactDataRepository;
        $this->contactDataSelectionSpecFactory = $contactDataSelectionSpecFactory;
        $this->credentialRecoveryRepository = $credentialRecoveryRepository;
    }

    /**
     * @param CreateCredentialRecoveryCommand $command
     * @return CredentialRecovery
     * @throws Exception
     */
    public function execute(CreateCredentialRecoveryCommand $command): CredentialRecovery
    {
        $primaryContactData = $command->getPrimaryContactData();
        $contactData = $this->contactDataRepository->selectOneSatisfying(
            $this->createSelectionSpec($primaryContactData),
        );

        $credentialRecovery = CredentialRecovery::create($primaryContactData, $contactData?->getUserId());
        $this->credentialRecoveryRepository->add($credentialRecovery);

        return $credentialRecovery;
    }

    /**
     * @param PrimaryContactData $primaryContactData
     * @return ContactDataSelectionSpecInterface
     */
    private function createSelectionSpec(PrimaryContactData $primaryContactData): ContactDataSelectionSpecInterface
    {
        return match (true) {
            $primaryContactData instanceof EmailAddress => $this->contactDataSelectionSpecFactory
                ->createHasEmailSelectionSpec($primaryContactData),
            $primaryContactData instanceof PhoneNumber => $this->contactDataSelectionSpecFactory
                ->createHasPhoneSelectionSpec($primaryContactData),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected primary contact data type %s.', $primaryContactData::class),
            ),
        };
    }
}
