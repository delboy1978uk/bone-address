<?php

declare(strict_types=1);

namespace Bone\Address\Entity;

use Bone\Address\Repository\AddressRepository;
use Bone\BoneDoctrine\Traits\HasId;
use Bone\BoneDoctrine\Traits\HasLocationCoordinates;
use Del\Person\Traits\HasManyToOnePerson;
use Del\Traits\HasCountryTrait;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Address implements JsonSerializable
{
    use HasId;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private $add1;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $add2;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $add3;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private $city;

    #[ORM\Column(type: 'string', length: 10, nullable: false)]
    private $postcode;

    use HasCountryTrait;
    use HasLocationCoordinates;
    use HasManyToOnePerson;

    public function getAdd1(): string
    {
        return $this->add1;
    }

    public function setAdd1(string $add1): void
    {
        $this->add1 = $add1;
    }

    public function getAdd2(): ?string
    {
        return $this->add2;
    }

    public function setAdd2(?string $add2): void
    {
        $this->add2 = $add2;
    }

    public function getAdd3(): ?string
    {
        return $this->add3;
    }

    public function setAdd3(?string $add3): void
    {
        $this->add3 = $add3;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'add1' => $this->getAdd1(),
            'add2' => $this->getAdd2(),
            'add3' => $this->getAdd3(),
            'city' => $this->getCity(),
            'postcode' => $this->getPostcode(),
            'country' => $this->getCountry(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'person' => $this->getPerson(),
        ];

        return $data;
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
