<?php

declare(strict_types=1);

namespace Bone\Address\Repository;

use Bone\Address\Entity\Address;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class AddressRepository extends EntityRepository
{
    /**
     * @param int $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return Address
     * @throws \Doctrine\ORM\ORMException
     */
    public function find($id, $lockMode = null, $lockVersion = null): Address
    {
        /** @var Address $address */
        $address =  parent::find($id, $lockMode, $lockVersion);

        if (!$address) {
            throw new EntityNotFoundException('Address not found.', 404);
        }

        return $address;
    }

    /**
     * @param Address $address
     * @return $address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Address $address): Address
    {
        if(!$address->getID()) {
            $this->_em->persist($address);
        }

        $this->_em->flush($address);

        return $address;
    }

    /**
     * @param Address $address
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(Address $address): void
    {
        $this->_em->remove($address);
        $this->_em->flush($address);
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalAddressCount(): int
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('count(a.id)');
        $query = $qb->getQuery();

        return (int) $query->getSingleScalarResult();
    }
}
