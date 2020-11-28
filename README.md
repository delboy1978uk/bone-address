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