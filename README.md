Ville de France
===============

[![Laravel 5.0](https://img.shields.io/badge/Laravel-5.0-orange.svg?style=flat-square)](http://laravel.com)
[![Source](https://img.shields.io/badge/source-arnotae%2Fville--france-blue.svg?style=flat-square)](https://github.com/arnotae/ville-france)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Database organisation change from the original version :

* Add some information in **ville**
* Add tables **departement** and **region**

Installation
------------

Add to `composer.json` file:

``` json
{
    "require": {
        "arnotae/ville-france": "~1.0"
    }
    "repositories": [
        {
          "type": "vcs",
          "url": "https://github.com/arnotae/ville-france"
        }
    ],
}
```

Add to `config/app.php` file:

``` php
'providers' => array(
	...
	'arnotae\VilleFrance\VilleFranceServiceProvider',
	...
```

In terminal:

``` bash
composer update
php artisan vendor:publish
php artisan migrate
php artisan ville:load
```

Credit
------------

Forked : https://github.com/aamant/ville-france

Data files are from : http://www.bibichette.com/