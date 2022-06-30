<?php

namespace App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox;

use InvalidArgumentException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Domain\Model\Outbox\OutboxRepositoryInterface;
use App\Context\Account\Domain\Model\Outbox\OutboxSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Messaging\Bus\MessageBusInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

use function sprintf;

/**
 * Class DispatchPriorityOutboxUseCase
 * @package App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox
 */
final class DispatchPriorityOutboxUseCase implements DispatchPriorityOutboxUseCaseInterface
{
    private const LIMIT_MIN_VALUE = 1;
    private const LIMIT_MAX_VALUE = 1000;

    /**
     * @var OutboxRepositoryInterface
     */
    private OutboxRepositoryInterface $outboxRepository;

    /**
     * @var OutboxSelectionSpecFactoryInterface
     */
    private OutboxSelectionSpecFactoryInterface $outboxSelectionSpecFactory;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * DispatchPriorityOutboxUseCase constructor.
     * @param OutboxRepositoryInterface $outboxRepository
     * @param OutboxSelectionSpecFactoryInterface $outboxSelectionSpecFactory
     * @param SerializerInterface $serializer
     * @param MessageBusInterface $messageBus
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        OutboxRepositoryInterface $outboxRepository,
        OutboxSelectionSpecFactoryInterface $outboxSelectionSpecFactory,
        SerializerInterface $serializer,
        MessageBusInterface $messageBus,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->outboxRepository = $outboxRepository;
        $this->outboxSelectionSpecFactory = $outboxSelectionSpecFactory;
        $this->serializer = $serializer;
        $this->messageBus = $messageBus;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param int $limit
     * @return DispatchPriorityOutboxResponse
     */
    public function execute(int $limit): DispatchPriorityOutboxResponse
    {
        if ($limit < 1 || $limit > 1000) {
            throw new InvalidArgumentException(
                sprintf(
                    'This value of SIZE should be between %d and %d',
                    self::LIMIT_MIN_VALUE,
                    self::LIMIT_MAX_VALUE
                )
            );
        }

        $outboxList = $this->outboxRepository->selectSatisfying(
            $this->outboxSelectionSpecFactory->createIsPrioritySelectionSpec($limit)
        );

        $totalSent = 0;

        if (!empty($outboxList)) {
            foreach ($outboxList as $outbox) {
                $this->processOutbox($outbox);
                $totalSent++;
            }
        }

        return new DispatchPriorityOutboxResponse($totalSent);
    }

    /**
     * @param Outbox $outbox
     */
    private function processOutbox(Outbox $outbox): void
    {
        $message = $this->serializer->denormalize($outbox->getData(), $outbox->getType());
        $this->transactionalSession->executeAtomically(
            function () use ($outbox, $message) {
                $this->messageBus->dispatch($message);
                $this->outboxRepository->remove($outbox);
            }
        );
    }
}
