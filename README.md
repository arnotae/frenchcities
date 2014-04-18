Ville de France
===============

Installation
------------

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "aamant/ville-france": "@stable"
    }
}
```

Add to file app.config.php

``` php
'providers' => array(
	...
	'Aamant\VilleFrance\VilleFranceServiceProvider',
	...
```

Add to file app.config.php

``` bash
php artisan migrate --package aamant/ville-france
php artisan ville:load
```
