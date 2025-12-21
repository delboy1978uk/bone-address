<?php

declare(strict_types=1);

namespace Bone\Address\Collection;

use Bone\Address\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use LogicException;

class AddressCollection extends ArrayCollection implements JsonSerializable
{
    /** @throws LogicException  */
    public function update(Address $address): AddressCollection
    {
        $key = $this->findKey($address);

        if($key) {
            $this->offsetSet($key,$address);

            return $this;
        }

        throw new LogicException('Address was not in the collection.');
    }

    public function append(Address $address): void
    {
        $this->add($address);
    }

    public function current(): ?Address
    {
        return parent::current();
    }

    public function findKey(Address $address): ?int
    {
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {

            if($it->current()->getId() == $address->getId()) {
                return $it->key();
            }

            $it->next();
        }

        return null;
    }

    public function findById(int $id): ?Address
    {
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {

            if($it->current()->getId() == $id) {
                return $it->current();
            }

            $it->next();
        }

        return null;
    }

    public function toArray(): array
    {
        $collection = [];
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {
            /** @var Address $row */
            $row = $it->current();
            $collection[] = $row->toArray();
            $it->next();
        }

        return $collection;
    }

    public function jsonSerialize(): string
    {
        return \json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
