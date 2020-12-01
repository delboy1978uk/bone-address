<?php

declare(strict_types=1);

namespace Bone\Address\Service;

use Bone\Address\Entity\Address;
use Bone\Address\Repository\AddressRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class AddressService
{
    /** @var EntityManager $em */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Address
     */
    public function createFromArray(array $data): Address
    {
        $address = new Address();

        return $this->updateFromArray($address, $data);
    }

    /**
     * @param Address $address
     * @param array $data
     * @return Address
     */
    public function updateFromArray(Address $address, array $data): Address
    {
        isset($data['id']) ? $address->setId($data['id']) : null;
        isset($data['add1']) ? $address->setAdd1($data['add1']) : $address->setAdd1('');
        isset($data['add2']) ? $address->setAdd2($data['add2']) : $address->setAdd2(null);
        isset($data['add3']) ? $address->setAdd3($data['add3']) : $address->setAdd3(null);
        isset($data['city']) ? $address->setCity($data['city']) : $address->setCity('');
        isset($data['postcode']) ? $address->setPostcode($data['postcode']) : $address->setPostcode('');
        isset($data['country']) ? $address->setCountry($data['country']) : $address->setCountry('');
        !empty($data['lat']) ? $address->setLat($data['lat']) : $address->setLat(null);
        !empty($data['lng']) ? $address->setLng($data['lng']) : $address->setLng(null);
        !empty($data['person']) ? $address->setPerson($data['person']) : null;

        return $address;
    }

    /**
     * @param Address $address
     * @return Address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAddress(Address $address): Address
    {
        return $this->getRepository()->save($address);
    }

    /**
     * @param Address $address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAddress(Address $address): void
    {
        $this->getRepository()->delete($address);
    }

    /**
     * @return AddressRepository
     */
    public function getRepository(): AddressRepository
    {
        /** @var AddressRepository $repository */
        $repository = $this->em->getRepository(Address::class);

        return $repository;
    }
}
