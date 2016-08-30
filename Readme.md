# Sledgehammer Laravel
Adds sledgehammer goodies to Laravel

* dump()
* ErrorHandling
* Mysql warnings & notices
* statusbar incl. SQL querylog

# Installation

Require this package in your composer.json and run composer update

```
"sledgehammer/laravel": "*"
```
(or run `composer require sledgehammer/laravel:*` directly):


After updating composer, add the ServiceProvider to the providers array in app/config/app.php
```
'Sledgehammer\Laravel\ServiceProvider',
```


# Statusbar

Add `@include('sledgehammer::statusbar')` before the `</body>` and run:

```
artisan asset:publish sledgehammer/core
artisan asset:publish sledgehammer/laravel
artisan view:publish sledgehammer/laravel
```

