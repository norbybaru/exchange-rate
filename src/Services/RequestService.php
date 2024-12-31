<?php namespace NorbyBaru\ExchangeRate\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Collection;
use NorbyBaru\ExchangeRate\Exception\ProviderRequestApiException;
use NorbyBaru\ExchangeRate\Models\ExchangeRate;
use NorbyBaru\ExchangeRate\Models\ExchangeRateHistory;

/**
 * Class RequestService
 * @package NorbyBaru\ExchangeRate\Services
 */
abstract class RequestService
{
    /** @var string  */
    private $baseCurrencyISO;

    private Client $client;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client([
            "base_uri" => $baseUrl,
        ]);
    }

    public function get(string $uri, array $params = []): array
    {
        return $this->request(method: "get", uri: $uri, params: $params);
    }

    protected function request(
        string $method,
        string $uri,
        array $params = []
    ): array {
        try {
            if ($method == "get") {
                $params = ["query" => $params];
            }

            $responseJson = $this->client->request($method, $uri, $params);
            $responseObject = json_decode($responseJson->getBody(), true);

            return $responseObject;
        } catch (BadResponseException $e) {
            $responseJson = $e->getResponse();
            $responseObject = json_decode(
                $responseJson->getBody()->getContents(),
                true
            );

            ProviderRequestApiException::throw($responseObject->getMessage());
        }
    }

    protected function decorator(
        Collection $rates,
        string $baseCurrencyISO
    ): Collection {
        $baseCurrency = $rates
            ->where("currency_iso", $baseCurrencyISO)
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
                    fn($rate) => $rate["currency_iso"] === $baseCurrencyISO
                );
        }

        return $rates;
    }

    protected function updateOrCreateRates(Collection $rates): void
    {
        ExchangeRate::query()->upsert(
            values: $rates->all(),
            uniqueBy: ["currency_iso", "base_currency_iso"]
        );

        ExchangeRateHistory::query()->insert($rates->all());
    }
}
