<?php declare(strict_types=1);

namespace Bone\Address\View\Extension;

use Bone\Address\Entity\Address;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class AddressExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('address', [$this, 'address']);
    }

    /**
     * @param Address $address
     * @return string
     */
    public function address(Address $address): string
    {
        $html = $address->getAdd1();
        $html .= $address->getAdd2() ? '<br>' . $address->getAdd2() : '';
        $html .= $address->getAdd3() ? '<br>' . $address->getAdd3() : '';
        $html .= '<br>' . $address->getCity() . ' ' . $address->getPostcode() . '<br>';
        $html .= $address->getCountry()->getName();

        return $html;
    }
}