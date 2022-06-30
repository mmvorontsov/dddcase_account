<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToRegistrationSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
final class DoctrineBelongsToRegistrationSelectionSpec implements DoctrineKeyMakerSelectionSpecInterface
{
    /**
     * @var RegistrationId
     */
    private RegistrationId $registrationId;

    /**
     * DoctrineBelongsToRegistrationSelectionSpec constructor.
     * @param RegistrationId $registrationId
     */
    public function __construct(RegistrationId $registrationId)
    {
        $this->registrationId = $registrationId;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(RegistrationKeyMaker::class, 'km')
            ->select('km', 'sc')
            ->leftJoin('km.secretCodes', 'sc')
            ->where($qb->expr()->in('km.registrationId', ':registrationId'))
            ->setParameter('registrationId', $this->registrationId);

        return $qb;
    }
}
