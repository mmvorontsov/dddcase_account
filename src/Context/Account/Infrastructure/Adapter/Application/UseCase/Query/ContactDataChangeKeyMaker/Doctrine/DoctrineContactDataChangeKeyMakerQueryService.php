<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\ContactDataChangeKeyMaker\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker\{
    ContactDataChangeKeyMakerQueryServiceInterface,
    ContactDataChangeKeyMakerRequest,
};
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineContactDataChangeKeyMakerQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\ContactDataChangeKeyMaker\Doctrine
 */
final class DoctrineContactDataChangeKeyMakerQueryService implements ContactDataChangeKeyMakerQueryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineContactDataChangeKeyMakerQueryService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ContactDataChangeKeyMakerRequest $request
     * @param UserId $userId
     * @return ContactDataChangeKeyMaker|null
     * @throws NonUniqueResultException
     */
    public function findKeyMaker(ContactDataChangeKeyMakerRequest $request, UserId $userId): ?ContactDataChangeKeyMaker
    {
        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('km', 'sc')
            ->from(ContactDataChangeKeyMaker::class, 'km')
            ->leftJoin('km.secretCodes', 'sc')
            ->innerJoin(
                ContactDataChange::class,
                'cdc',
                Expr\Join::WITH,
                'cdc.contactDataChangeId = km.contactDataChangeId',
            )
            ->where('cdc.userId = :userId')
            ->andWhere('cdc.contactDataChangeId = :contactDataChangeId')
            ->setParameters(
                [
                    'userId' => $userId,
                    'contactDataChangeId' => $request->getContactDataChangeId(),
                ],
            )
            ->getQuery()
            ->setHint(Query::HINT_READ_ONLY, true);

        return $query->getOneOrNullResult();
    }
}
