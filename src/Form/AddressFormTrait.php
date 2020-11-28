<?php

declare(strict_types=1);

namespace Bone\Address\Form;

use Bone\User\Form\Transformer\CountryTransformer;
use Del\Form\Field\Hidden;
use Del\Form\Field\Select;
use Del\Form\Field\Text;
use Del\Form\FormInterface;
use Del\Repository\CountryRepository;

trait AddressFormTrait
{
    public function addAddressFields(FormInterface $form): void
    {
        $add1 = new Text('add1');
        $add1->setLabel('Address');
        $add1->setRequired(true);
        $form->addField($add1);

        $add2 = new Text('add2');
        $form->addField($add2);

        $add3 = new Text('add3');
        $form->addField($add3);

        $city = new Text('city');
        $city->setLabel('City');
        $city->setRequired(true);
        $form->addField($city);

        $postcode = new Text('postcode');
        $postcode->setLabel('Postcode');
        $postcode->setRequired(true);
        $form->addField($postcode);

        $country = new Select('country');
        $country->setLabel('Country');
        $country->setRequired(true);
        $country->setTransformer(new CountryTransformer());
        $countryRepository = new CountryRepository();
        $countries = $countryRepository->findAllCountries();
        $country->setOption('', '');
        foreach ($countries as $c) {
            $country->setOption($c->getIso(), $c->getName());
        }
        $form->addField($country);

        $lat = new Hidden('lat');
        $lat->setLabel('Latitude');
        $form->addField($lat);

        $lng = new Hidden('lng');
        $lng->setLabel('Longitude');
        $form->addField($lng);
    }
}
