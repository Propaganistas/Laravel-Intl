# Laravel Intl

[![Build Status](https://travis-ci.org/Propaganistas/Laravel-Intl.svg?branch=master)](https://travis-ci.org/Propaganistas/Laravel-Intl)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Intl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Intl/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Intl/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Intl/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/propaganistas/laravel-intl/v/stable)](https://packagist.org/packages/propaganistas/laravel-intl)
[![Total Downloads](https://poser.pugx.org/propaganistas/laravel-intl/downloads)](https://packagist.org/packages/propaganistas/laravel-intl)
[![License](https://poser.pugx.org/propaganistas/laravel-intl/license)](https://packagist.org/packages/propaganistas/laravel-intl)

Easy to use internationalization functions for Laravel 5 based on various libraries for easy retrieval of
localized values and formatting of numeric values into their localized patterns.

### Overview

* [Installation](#installation)
* [Usage](#usage)
    * [Country](#country)
    * [Currency](#currency)
    * [Date](#date)
    * [Language](#language)
    * [Number](#number)
* [Changing locales](#changing-locales)
    
### Installation

Run the following command to install the latest version of the package

```bash
composer require propaganistas/laravel-intl
```
#### Laravel
In your app config, add the Service Provider to the `$providers` array

 ```php
'providers' => [
    ...
    Propaganistas\LaravelIntl\IntlServiceProvider::class,
],
```
#### Lumen
In `bootstrap/app.php`, register the Service Provider

 ```php
$app->register(Propaganistas\LaravelIntl\IntlServiceProvider::class);
```

### Usage

> Note: **always** use the helper functions or Facades.

#### Country

Output localized country names.
```php
use Propaganistas\LaravelIntl\Facades\Country;

// Application locale: en
Country::name('US'); // United States
Country::currency('US'); // USD
Country::all(); // ['US' => 'United States', 'BE' => 'Belgium', ...]

// Application locale: nl
Country::name('US'); // Verenigde Staten
Country::all(); // ['US' => 'Verenigde Staten', 'BE' => 'België', ...]
```

```php
// Application locale: en
country('US'); // United States
country()->currency('US'); // USD
country()->all(); // ['US' => 'United States', 'BE' => 'Belgium', ...]
```

#### Currency

Output localized currency names and format currency amounts into their localized pattern.

```php
use Propaganistas\LaravelIntl\Facades\Currency;

// Application locale: en
Currency::name('USD'); // US Dollar
Currency::symbol('USD'); // $
Currency::format(1000, 'USD'); // $1,000.00
Currency::formatAccounting(-1234, 'USD'); // ($1,234.00)
Currency::all(); // ['USD' => 'US Dollar', 'EUR' => 'Euro', ...]

// Application locale: nl
Currency::name('USD'); // Amerikaanse dollar
Currency::format(1000, 'USD'); // $ 1.000,00
Currency::formatAccounting(-1234, 'USD'); // (US$ 1.234,00)
Currency::all(); // ['USD' => 'Amerikaanse dollar', 'EUR' => 'Euro', ...]
```

```php
// Application locale: en
currency('USD'); // US Dollar
currency(1000, 'USD'); // $1,000.00
currency()->symbol('USD'); // $
currency()->all(); // ['USD' => 'US Dollar', 'EUR' => 'Euro', ...]
```

Parse localized values into native PHP numbers.

```php
use Propaganistas\LaravelIntl\Facades\Currency;

// Application locale: nl
Currency::parse('€ 1.234,50'); // 1234.5
```

```php
// Application locale: nl
currency()->parse('€ 1.234,50'); // 1234.5
```

#### Date

Output localized dates.

Use the Facade (`Propaganistas\LaravelIntl\Facades\Carbon`) or the helper function (`carbon()`) as if it were [Carbon](http://carbon.nesbot.com).

#### Language

Output localized language names.

```php
use Propaganistas\LaravelIntl\Facades\Language;

// Application locale: en
Language::name('en'); // English
Language::all(); // ['en' => 'English', 'nl' => 'Dutch', ...]

// Application locale: nl
Language::name('en'); // Engels
Language::all(); // ['en' => 'Engels', 'nl' => 'Nederlands', ...]
```

```php
// Application locale: en
language('en'); // English
language()->all(); // ['en' => 'English', 'nl' => 'Dutch', ...]
```

#### Number

Output localized numeric values into their localized pattern.

```php
use Propaganistas\LaravelIntl\Facades\Number;

// Application locale: en
Number::format(1000); // 1,000
Number::percent(75); // 75%

// Application locale: fr
Number::format(1000); // 1 000
Number::percent(75); // 75 %
```

```php
// Application locale: en
number(1000); // 1,000
number()->percent(75); // 75%
```

Parse localized values into native PHP numbers.

```php
use Propaganistas\LaravelIntl\Facades\Number;

// Application locale: fr
Number::parse('1 000'); // 1000
Number::parse('1,5'); // 1.5
```

```php
// Application locale: fr
number()->parse('1 000'); // 1000
number()->parse('1,5'); // 1.5
```

### Changing locales

Ever feel the need to use a locale other than the current application locale? You can temporarily use another locale by using the `forLocale()` method.

```php
country()->name('US'); // United States

country()->forLocale('nl', function($country) {
    return $country->name('US');
}); // Verenigde Staten

country()->name('US'); // United States
```

Alternatively, you can force each component individually to the preferred locale for the remainder of the application by calling the `setLocale()` on the helper function or Facade.
Usually you'd set this in the `boot()` method of a *ServiceProvider*.

```php
country()->setLocale($locale);
currency()->setLocale($locale);
carbon()->setLocale($locale);
language()->setLocale($locale);
number()->setLocale($locale);

country()->setFallbackLocale($locale);
currency()->setFallbackLocale($locale);
carbon()->setFallbackLocale($locale);
language()->setFallbackLocale($locale);
number()->setFallbackLocale($locale);
```
