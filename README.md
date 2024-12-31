# Laravel Exchange Rate
Laravel Exchange Rate Package Allows to convert money from one currency to another using latest exchange rate on market

## Supported Providers
- [x] [Exchangerates](https://exchangeratesapi.io)
- [x] [European Central Bank](https://www.ecb.europa.eu)
- [ ] [ExchangeRate-API](https://www.exchangerate-api.com)
- [ ] [OpenExchangeRates](https://openexchangerates.org)
- [ ] [CurrencyLayer](https://currencylayer.com)
- [ ] [CurrencyConverterAPI](https://www.currencyconverterapi.com)

## Installation

```bash
composer require norbybaru/exchange-rate
```

Publish Config `config/exchange-rate.php`
```bash
php artisan vendor:publish --tag="exchange-rate-config"
```

Publish Migrations
```bash
php artisan vendor:publish --tag="exchange-rate-migration"
```

Run Migration
```bash
php artisan migrate
```

## Usage
Update exchange rate to get latest rate on the market.
Run below command to get latest exchange rate

```bash
php artisan exchange-rate:update
```
My advice is to run this command as cron job to update exchange rate daily.
You could learn more about scheduler [Laravel Scheduler](https://laravel.com/docs/scheduling)

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
