Ville de France
===============

I've just changed the database organisation from the original version :

* Added some information in **ville**
* Added tables **departement** and **region**

Installation
------------

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "arnotae/ville-france": "@stable"
    }
}
```

Add to file app.config.php

``` php
'providers' => array(
	...
	'arnotae\VilleFrance\VilleFranceServiceProvider',
	...
```

Add to file app.config.php

``` bash
php artisan migrate --package arnotae/ville-france
php artisan ville:load
```

Credit
------------

Forked : https://github.com/aamant/ville-france

Data files are from : http://www.bibichette.com/