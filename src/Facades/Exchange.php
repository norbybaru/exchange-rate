<?php namespace NorbyBaru\ExchangeRate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Exchange
 *
 * @method static float rate(string $currency = null, $round = 2)
 * @method static \NorbyBaru\ExchangeRate\Money convert($amount, $fromCurrencyISO, $toCurrencyISO)
 * @method static  \NorbyBaru\ExchangeRate\Money money($amount, $currency)
 *
 * @package NorbyBaru\ExchangeRate\Facades
 * @see \NorbyBaru\ExchangeRate\Exchanger
 */
class Exchange extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'Exchanger';
    }
}
