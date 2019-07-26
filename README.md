# Laravel Exchange Rate
Allows to convert money from one currency to another using latest exchange rate on market

## Installation

```php
$ composer install norbybaru/exchange-rate
```
Publish Config `config/exchange.php`
```php
$ php artisan vendor:publish --provider="NorbyBaru\ExchangeRate\ExchangeRateServiceProvider"
```

Run Migration
```php
$ php artisan migrate
```

## Usage
Update exchange rate to get latest rate on the market.
Run below command to get latest exchange rate

```php
$ php artisan rate:update
```

* Get Rate
```php
<?php
use NorbyBaru\ExchangeRate\Facades\Exchange;

$rate = Exchange::rate("USD");

```

* Convert Currency
```php
<?php

use NorbyBaru\ExchangeRate\Facades\Exchange;

$money = Exchange::convert(5000, 'USD', 'ZAR');

```
