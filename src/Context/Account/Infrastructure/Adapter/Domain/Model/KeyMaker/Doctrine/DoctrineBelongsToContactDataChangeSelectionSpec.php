<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToContactDataChangeSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
final class DoctrineBelongsToContactDataChangeSelectionSpec implements DoctrineKeyMakerSelectionSpecInterface
{
    /**
     * @var ContactDataChangeId
     */
    private ContactDataChangeId $contactDataChangeId;

    /**
     * DoctrineBelongsToContactDataChangeSelectionSpec constructor.
     * @param ContactDataChangeId $contactDataChangeId
     */
    public function __construct(ContactDataChangeId $contactDataChangeId)
    {
        $this->contactDataChangeId = $contactDataChangeId;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(ContactDataChangeKeyMaker::class, 'km')
            ->select('km', 'sc')
            ->leftJoin('km.secretCodes', 'sc')
            ->where($qb->expr()->in('km.contactDataChangeId', ':contactDataChangeId'))
            ->setParameter('contactDataChangeId', $this->contactDataChangeId);

        return $qb;
    }
}
