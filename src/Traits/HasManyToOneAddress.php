<?php

declare(strict_types=1);

namespace Bone\Address\Traits;

use Bone\Address\Entity\Address;
use Doctrine\ORM\Mapping as ORM;

trait HasManyToOneAddress
{
    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'addresses', cascade: ['persist'])]
    private Address $address;

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}
