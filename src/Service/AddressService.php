<?php

declare(strict_types=1);

namespace Bone\Address\Service;

use Bone\Address\Entity\Address;
use Bone\Address\Repository\AddressRepository;
use Del\Factory\CountryFactory;
use Doctrine\ORM\EntityManager;

class AddressService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createFromArray(array $data): Address
    {
        $address = new Address();

        return $this->updateFromArray($address, $data);
    }

    public function updateFromArray(Address $address, array $data): Address
    {
        isset($data['id']) ? $address->setId($data['id']) : null;
        isset($data['add1']) ? $address->setAdd1($data['add1']) : $address->setAdd1('');
        isset($data['add2']) ? $address->setAdd2($data['add2']) : $address->setAdd2(null);
        isset($data['add3']) ? $address->setAdd3($data['add3']) : $address->setAdd3(null);
        isset($data['city']) ? $address->setCity($data['city']) : $address->setCity('');
        isset($data['postcode']) ? $address->setPostcode($data['postcode']) : $address->setPostcode('');
        isset($data['country']) ? $address->setCountry(CountryFactory::generate($data['country'])) : null;
        !empty($data['latitude']) ? $address->setLatitude($data['latitude']) : $address->setLatitude(0);
        !empty($data['longitude']) ? $address->setLongitude($data['longitude']) : $address->setLongitude(0);
        !empty($data['person']) ? $address->setPerson($data['person']) : null;

        return $address;
    }

    public function saveAddress(Address $address): Address
    {
        return $this->getRepository()->save($address);
    }

    public function deleteAddress(Address $address): void
    {
        $this->getRepository()->delete($address);
    }

    public function getRepository(): AddressRepository
    {
        /** @var AddressRepository $repository */
        $repository = $this->em->getRepository(Address::class);

        return $repository;
    }
}
