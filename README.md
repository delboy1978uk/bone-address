# address
Address package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-address
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Address\AddressPackage;

return [
    'packages' => [
        // packages here...,
        AddressPackage::class,
    ],
    // ...
];
```
Run database migrations and you are ready to access `/admin/address`
```
bone migrant:diff
bone migrant:migrate
bone migrant:generate-proxies
```
### admin routes
You can access `/admin/address` to get SessionAuth protected CRUD pages. We will make these routes able to be 
enabled/disabled in a future release.

`setCountry(Country $country)` now takes a Country object as of v2.0.0.  You can create a Country object by passing in 
the ISO code:
```php
$country = CountryFactory::generate('GB');
```