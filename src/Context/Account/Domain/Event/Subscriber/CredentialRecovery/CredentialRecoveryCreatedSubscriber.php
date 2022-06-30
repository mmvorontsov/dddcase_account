<?php

namespace App\Context\Account\Domain\Event\Subscriber\CredentialRecovery;

use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryCreated;
use App\Context\Account\Domain\Model\KeyMaker\CreateCredentialRecoveryKeyMakerCommand;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use Exception;

use function is_null;

/**
 * Class CredentialRecoveryCreatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\CredentialRecovery
 */
final class CredentialRecoveryCreatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * CredentialRecoveryCreatedSubscriber constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     */
    public function __construct(KeyMakerRepositoryInterface $keyMakerRepository)
    {
        $this->keyMakerRepository = $keyMakerRepository;
    }

    /**
     * @param CredentialRecoveryCreated $event
     * @throws Exception
     */
    public function __invoke(CredentialRecoveryCreated $event): void
    {
        $this->createCredentialRecoveryKeyMaker($event);
    }

    /**
     * @param CredentialRecoveryCreated $event
     * @throws Exception
     */
    private function createCredentialRecoveryKeyMaker(CredentialRecoveryCreated $event): void
    {
        $credentialRecovery = $event->getCredentialRecovery();
        $primaryContactData = $credentialRecovery->getBy();

        // Do not send secret codes (isMute:true) if user is not defined (not found)
        $isMute = is_null($credentialRecovery->getUserId());

        $credentialRecoveryKeyMaker = CredentialRecoveryKeyMaker::create(
            new CreateCredentialRecoveryKeyMakerCommand(
                $primaryContactData,
                $credentialRecovery->getCredentialRecoveryId(),
                $isMute,
                $credentialRecovery->getExpiredAt(),
            ),
        );

        $this->keyMakerRepository->add($credentialRecoveryKeyMaker);
    }
}
