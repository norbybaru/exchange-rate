<?php

namespace NorbyBaru\ExchangeRate\Facades;

use Illuminate\Support\Facades\Facade;
use NorbyBaru\ExchangeRate\Money;

/**
 *
 * @method static float rate(string $currency = null, $round = 2)
 * @method static Money convert(float $amount, string $fromCurrencyISO, string $toCurrencyISO)
 * @method static Money money(float $amount, string $currency)
 *
 * @see \NorbyBaru\ExchangeRate\Exchanger
 */
class Exchange extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return "Exchanger";
    }
}
