<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHasPhoneSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
final class DoctrineHasPhoneSelectionSpec implements DoctrineContactDataSelectionSpecInterface
{
    /**
     * @var PhoneNumber
     */
    private PhoneNumber $phone;

    /**
     * DoctrineHasPhoneSelectionSpec constructor.
     * @param PhoneNumber $phone
     */
    public function __construct(PhoneNumber $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(ContactData::class, 'cd')
            ->select('cd')
            ->where($qb->expr()->eq('cd.phone', ':phone'))
            ->setParameter('phone', $this->phone);

        return $qb;
    }
}
