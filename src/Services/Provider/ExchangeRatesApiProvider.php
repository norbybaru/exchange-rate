<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate\Services\Provider;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use NorbyBaru\ExchangeRate\Exception\ProviderRequestApiException;
use NorbyBaru\ExchangeRate\Services\Contract\ExchangeRateContract;
use NorbyBaru\ExchangeRate\Services\RequestService;

class ExchangeRatesApiProvider extends RequestService implements ExchangeRateContract
{
    private string $baseUrl = 'https://api.exchangeratesapi.io';

    public function __construct(protected string $baseCurrencyISO = 'USD')
    {
        parent::__construct($this->baseUrl);
    }

    public function latest()
    {
        if (! empty($this->getAccessKey())) {
            $params['access_key'] = $this->getAccessKey();
        }

        $response = $this->get(uri: 'latest', params: $params ?? []);

        if ($response['success'] === false) {
            $this->handleError($response);
        }

        $sourceUpdatedDate = $response['date'];

        $rates = collect($response['rates'])->map(function (
            $rate,
            $currencyIso
        ) use ($sourceUpdatedDate) {
            return [
                'currency_iso' => $currencyIso,
                'rate' => $rate,
                'base_currency_iso' => $this->baseCurrencyISO,
                'source_updated_at' => Carbon::parse(
                    $sourceUpdatedDate
                )->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        });

        $rates = $this->decorator(
            rates: $rates,
            baseCurrencyISO: $this->baseCurrencyISO
        );

        $this->updateOrCreateRates(rates: $rates);
    }

    protected function getAccessKey(): string
    {
        return Arr::get($this->config(), 'access_key', '');
    }

    private function config(): array
    {
        return Config::get('exchange-rate')['providers']['exchangeratesapi'];
    }

    private function handleError(array $response): void
    {
        $error = $response['error'];
        match ($error['code']) {
            101 => ProviderRequestApiException::throw(
                Arr::get($error, 'info', 'Invalid API key')
            ),
            104 => ProviderRequestApiException::throw(
                Arr::get($error, 'info', 'Usage limit reached')
            ),
            default => ProviderRequestApiException::throw(
                Arr::get($error, 'info', 'Unknown error')
            ),
        };
    }
}
