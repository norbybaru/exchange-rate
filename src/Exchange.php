<?php namespace NorbyBaru\ExchangeRate;

use NorbyBaru\ExchangeRate\Models\ExchangeRate;

/**
 * Class Exchange
 * @package NorbyBaru\ExchangeRate
 */
class Exchange
{
    /** @var string  */
    protected $baseCurrency;

    /**
     * Exchange constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->baseCurrency = strtoupper($config['base_currency']);
    }

    /**
     * @param string|null $currency
     * @param int         $round
     *
     * @return float
     */
    public function rate(string $currency = null, $round = 2)
    {
        $currency = strtoupper($currency);

        /** @var ExchangeRate $exchange */
        $exchange = ExchangeRate::query()
            ->where('currency_iso', $currency)
            ->where('base_currency_iso', $this->baseCurrency)
            ->firstOrFail();

        return round($exchange->rate, $round);
    }

    /**
     * @param     $amount
     * @param     $fromCurrencyISO
     * @param     $toCurrencyISO
     *
     * @return \NorbyBaru\ExchangeRate\Money
     */
    public function convert($amount, $fromCurrencyISO, $toCurrencyISO)
    {
        $from = strtoupper($fromCurrencyISO);
        $to = strtoupper($toCurrencyISO);

        /** @var ExchangeRate $from */
        $from = ExchangeRate::query()
            ->where('currency_iso', $from)
            ->where('base_currency_iso', $this->baseCurrency)
            ->firstOrFail();

        /** @var ExchangeRate $to */
        $to = ExchangeRate::query()
            ->where('currency_iso', $to)
            ->where('base_currency_iso', $this->baseCurrency)
            ->firstOrFail();

        $result = $amount * ($from->rate/$to->rate);

        return new Money($result, $to->currency_iso, $this->baseCurrency, $to->source_updated_at);
    }

    /**
     * @param $amount
     * @param $currency
     *
     * @return \NorbyBaru\ExchangeRate\Money
     */
    public function money($amount, $currency): Money
    {
        return new Money($amount, $currency, $this->baseCurrency);
    }
}