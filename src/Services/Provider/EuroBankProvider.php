<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate\Services\Provider;

use Illuminate\Support\Carbon;
use NorbyBaru\ExchangeRate\Services\Contract\ExchangeRateContract;
use NorbyBaru\ExchangeRate\Services\RequestService;

class EuroBankProvider extends RequestService implements ExchangeRateContract
{
    private $baseUrl = "https://www.ecb.europa.eu/";

    public function __construct(protected string $baseCurrencyISO = "USD")
    {
        parent::__construct($this->baseUrl);
    }

    public function latest()
    {
        $uri = "/stats/eurofxref/eurofxref-daily.xml";

        $xml = simplexml_load_file($this->baseUrl . $uri);

        $sourceUpdatedDate = (string) $xml->Cube->Cube->attributes()["time"];

        $rates = collect([]);
        foreach ($xml->Cube->Cube->Cube as $rate) {
            $rates->push([
                "currency_iso" => (string) $rate->attributes()->currency,
                "rate" => (float) $rate->attributes()->rate,
                "base_currency_iso" => $this->baseCurrencyISO,
                "source_updated_at" => Carbon::parse(
                    $sourceUpdatedDate
                )->toDateTimeString(),
                "created_at" => Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);
        }

        $baseCurrency = $rates
            ->where("currency_iso", $this->baseCurrencyISO)
            ->first();

        if ($baseCurrency["rate"] !== 1) {
            $rates = $rates
                ->map(function ($rate) use ($baseCurrency) {
                    $rate["rate"] = round(
                        $rate["rate"] / $baseCurrency["rate"],
                        3
                    );
                    return $rate;
                })
                ->reject(
                    fn($rate) => $rate["currency_iso"] ===
                        $this->baseCurrencyISO
                );
        }

        $rates = $this->decorator(
            rates: $rates,
            baseCurrencyISO: $this->baseCurrencyISO
        );

        $this->updateOrCreateRates(rates: $rates);
    }
}
