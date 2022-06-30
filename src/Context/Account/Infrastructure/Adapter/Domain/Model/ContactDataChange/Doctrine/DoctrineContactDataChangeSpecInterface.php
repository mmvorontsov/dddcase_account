<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine;

use Doctrine\ORM\QueryBuilder;
use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface DoctrineContactDataChangeSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine
 */
interface DoctrineContactDataChangeSpecInterface extends SpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function satisfyingElements(QueryBuilder $qb): QueryBuilder;
}
