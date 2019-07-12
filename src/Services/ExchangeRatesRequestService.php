<?php namespace NorbyBaru\ExchangeRate\Services;

use Carbon\Carbon;
use NorbyBaru\ExchangeRate\Models\ExchangeRate;
use NorbyBaru\ExchangeRate\Models\ExchangeRateHistory;

/**
 * Class RateRequestService
 * @package NorbyBaru\ExchangeRate\Services
 */
class ExchangeRatesRequestService extends RequestService
{
    /** @var string  */
    private $baseCurrencyISO;

    /** @var string  */
    private $baseUrl = "https://api.exchangeratesapi.io/";

    /**
     * ExchangeRatesRequestService constructor.
     *
     * @param string $baseCurrencyISO
     */
    public function __construct(string $baseCurrencyISO = 'USD')
    {
        parent::__construct($this->baseUrl);
        $this->baseCurrencyISO = $baseCurrencyISO;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function latest()
    {
        $params = [
            'base' => $this->baseCurrencyISO
        ];

        $response = $this->request('get', 'latest', $params);

        $sourceUpdatedDate = $response->date;

        $rates = collect($response->rates)
            ->map(function ($rate, $currencyIso) use ($sourceUpdatedDate) {
                return [
                    'currency_iso'  => $currencyIso,
                    'rate'          => $rate,
                    'base_currency_iso' => $this->baseCurrencyISO,
                    'source_updated_at' => Carbon::parse($sourceUpdatedDate),
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ];
            })
            ->all();

        //TODO: Refactor this to always have fresh db for rates and log changes to history table
        ExchangeRate::query()->truncate();

        ExchangeRate::query()->insert($rates);

        ExchangeRateHistory::query()->insert($rates);
    }
}
