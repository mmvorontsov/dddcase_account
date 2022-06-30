<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine;

use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineCredentialSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine
 */
interface DoctrineCredentialSelectionSpecInterface extends CredentialSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
