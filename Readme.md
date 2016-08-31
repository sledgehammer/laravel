# Sledgehammer Laravel
Adds sledgehammer goodies to Laravel

* statusbar
* debug ajax calls with DebugR
* Sledgehammer\dump()
* Curl

# Installation

Require this package in your composer.json and run composer update

```
"sledgehammer/laravel": "*"
```
(or run `composer require sledgehammer/laravel:*` directly):


After updating composer, add the ServiceProvider to the providers array in app/config/app.php
```
'Sledgehammer\Laravel\SledgehammerServiceProvider',
```

Add DebugRMiddleware to the $middleware array in app/Http/Kernel.php
'Sledgehammer\Laravel\DebugRMiddleware'

# Statusbar

Add `@include('sledgehammer::statusbar')` before the `</body>` and run:

```
artisan vendor:publish
```

