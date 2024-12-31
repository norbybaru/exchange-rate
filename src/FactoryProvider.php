<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate;

use NorbyBaru\ExchangeRate\Services\Contract\ExchangeRateContract;
use NorbyBaru\ExchangeRate\Services\Provider\EuroBankProvider;
use NorbyBaru\ExchangeRate\Services\Provider\ExchangeRatesApiProvider;

class FactoryProvider
{
    public function __construct(protected array $config)
    {
    }

    public function getProvider()
    {
        $baseCurrencyISO = $this->config["base_currency"];
        switch ($this->config["provider"]) {
            case "exchangeratesapi":
                return new ExchangeRatesApiProvider(
                    baseCurrencyISO: $baseCurrencyISO
                );
            case "eurobank":
                return new EuroBankProvider(baseCurrencyISO: $baseCurrencyISO);
            default:
                throw new \Exception("Provider not found");
        }
    }

    public static function make(array $config): ExchangeRateContract
    {
        return (new self($config))->getProvider();
    }
}
