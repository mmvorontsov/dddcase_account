<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;
use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface DoctrineKeyMakerSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
interface DoctrineKeyMakerSelectionSpecInterface extends KeyMakerSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
