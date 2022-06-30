<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use Doctrine\ORM\QueryBuilder;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;

/**
 * Class DoctrineBelongsToCredentialRecoverySelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
final class DoctrineBelongsToCredentialRecoverySelectionSpec implements DoctrineKeyMakerSelectionSpecInterface
{
    /**
     * @var CredentialRecoveryId
     */
    private CredentialRecoveryId $credentialRecoveryId;

    /**
     * DoctrineBelongsToCredentialRecoverySelectionSpec constructor.
     * @param CredentialRecoveryId $credentialRecoveryId
     */
    public function __construct(CredentialRecoveryId $credentialRecoveryId)
    {
        $this->credentialRecoveryId = $credentialRecoveryId;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(CredentialRecoveryKeyMaker::class, 'km')
            ->select('km', 'sc')
            ->leftJoin('km.secretCodes', 'sc')
            ->where($qb->expr()->in('km.credentialRecoveryId', ':credentialRecoveryId'))
            ->setParameter('credentialRecoveryId', $this->credentialRecoveryId);

        return $qb;
    }
}
