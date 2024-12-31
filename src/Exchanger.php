<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate;

use NorbyBaru\ExchangeRate\Models\ExchangeRate;

class Exchanger
{
    public function __construct(protected string $baseCurrency) {}

    public function rate(?string $currency = null, int $round = 2): float
    {
        $currency = strtoupper($currency);

        /** @var ExchangeRate $exchange */
        $exchange = ExchangeRate::query()
            ->where('currency_iso', $currency)
            ->where('base_currency_iso', $this->baseCurrency)
            ->firstOrFail();

        return round($exchange->rate, $round);
    }

    public function convert(
        float $amount,
        string $fromCurrencyISO,
        string $toCurrencyISO
    ): Money {
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

        if ($fromCurrencyISO == $this->baseCurrency) {
            $result = $amount * $to->rate;
            $rate = round($to->rate, 4);
        } else {
            $result = $to->rate * ($amount / $from->rate);
            $rate = round($to->rate / $from->rate, 4);
        }

        $rate = "1 {$from->currency_iso} = {$rate} {$to->currency_iso}";

        return new Money(
            $result,
            $to->currency_iso,
            $this->baseCurrency,
            $rate,
            $to->source_updated_at
        );
    }

    public function money(float $amount, string $currency): Money
    {
        return new Money($amount, $currency, $this->baseCurrency);
    }
}
