Cities of France
===============

[![Laravel 5.0](https://img.shields.io/badge/Laravel-5.0-orange.svg?style=flat-square)](http://laravel.com)
[![Source](https://img.shields.io/badge/source-arnotae%2Ffrenchcities-blue.svg?style=flat-square)](https://github.com/arnotae/frenchcities)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Database organisation change from the original version :

* Pass to English
* Add some informations in **cities**
* Add tables **departments** and **regions**

Installation
------------

Require with `composer`:

```
composer require barryvdh/laravel-ide-helper
```

Add to `config/app.php` file:

``` php
'providers' => array(
	...
	'arnotae\FrenchCities\FrenchCitiesServiceProvider',
	...
```

In terminal:

``` bash
composer update
php artisan vendor:publish
php artisan migrate
php artisan city:load
```

Credit
------------

Forked : https://github.com/aamant/ville-france

Data files are from : http://www.bibichette.com/