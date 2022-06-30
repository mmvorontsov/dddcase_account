<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine;

use App\Context\Account\Domain\Model\Credential\Credential;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHasUsernameSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine
 */
final class DoctrineHasUsernameSelectionSpec implements DoctrineCredentialSelectionSpecInterface
{
    /**
     * @var string
     */
    private string $username;

    /**
     * DoctrineHasUsernameSelectionSpec constructor.
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(Credential::class, 'c')
            ->select('c')
            ->where($qb->expr()->eq('c.username', ':username'))
            ->setParameter('username', $this->username);

        return $qb;
    }
}
