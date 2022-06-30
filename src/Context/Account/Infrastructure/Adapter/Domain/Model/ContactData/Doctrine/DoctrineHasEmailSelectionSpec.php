<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use Doctrine\ORM\QueryBuilder;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class DoctrineHasEmailSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
final class DoctrineHasEmailSelectionSpec implements DoctrineContactDataSelectionSpecInterface
{
    /**
     * @var EmailAddress
     */
    private EmailAddress $email;

    /**
     * DoctrineHasEmailSelectionSpec constructor.
     * @param EmailAddress $email
     */
    public function __construct(EmailAddress $email)
    {
        $this->email = $email;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(ContactData::class, 'cd')
            ->select('cd')
            ->where($qb->expr()->eq('cd.email', ':email'))
            ->setParameter('email', $this->email);

        return $qb;
    }
}
