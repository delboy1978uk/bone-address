<?php

declare(strict_types=1);

namespace Bone\Address\Entity;

use Del\Person\Entity\Person;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="\Bone\Address\Repository\AddressRepository")
 */
class Address implements JsonSerializable
{
    /**
     * @var int $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string $add1
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $add1;

    /**
     * @var string $add2
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $add2;

    /**
     * @var string $add3
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $add3;

    /**
     * @var string $city
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string $postcode
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $postcode;

    /**
     * @var string $country
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    private $country;

    /**
     * @var float $lat
     * @ORM\Column(type="float", precision=11, scale=6, nullable=true)
     */
    private $lat;

    /**
     * @var float $lng
     * @ORM\Column(type="float", precision=11, scale=6, nullable=true)
     */
    private $lng;

    /**
     * @var Person $person
     * @ORM\ManyToOne(targetEntity="Del\Person\Entity\Person")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAdd1(): string
    {
        return $this->add1;
    }

    /**
     * @param string $add1
     */
    public function setAdd1(string $add1): void
    {
        $this->add1 = $add1;
    }

    /**
     * @return string
     */
    public function getAdd2(): ?string
    {
        return $this->add2;
    }

    /**
     * @param string|null $add2
     */
    public function setAdd2(?string $add2): void
    {
        $this->add2 = $add2;
    }

    /**
     * @return string
     */
    public function getAdd3(): ?string
    {
        return $this->add3;
    }

    /**
     * @param string|null $add3
     */
    public function setAdd3(?string $add3): void
    {
        $this->add3 = $add3;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return float
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     */
    public function setLat(?float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     */
    public function setLng(?float $lng): void
    {
        $this->lng = $lng;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

    /**
     * @return array
     */
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
            'lat' => $this->getLat(),
            'lng' => $this->getLng(),
            'person' => $this->getPerson(),
        ];

        return $data;
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
