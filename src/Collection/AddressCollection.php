<?php

declare(strict_types=1);

namespace Bone\Address\Collection;

use Bone\Address\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use LogicException;

class AddressCollection extends ArrayCollection implements JsonSerializable
{
    /**
     * @param Address $address
     * @return $this
     * @throws LogicException
     */
    public function update(Address $address): AddressCollection
    {
        $key = $this->findKey($address);

        if($key) {
            $this->offsetSet($key,$address);

            return $this;
        }

        throw new LogicException('Address was not in the collection.');
    }

    /**
     * @param Address $address
     */
    public function append(Address $address): void
    {
        $this->add($address);
    }

    /**
     * @return Address|null
     */
    public function current(): ?Address
    {
        return parent::current();
    }

    /**
     * @param Address $address
     * @return int|null
     */
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

    /**
     * @param int $id
     * @return Address|null
     */
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

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return \json_encode($this->toArray());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
