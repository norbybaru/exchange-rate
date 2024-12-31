<?php

namespace NorbyBaru\ExchangeRate\Services;

use NorbyBaru\ExchangeRate\Services\Contract\ExchangeRateContract;

class ExchangeRatesRequestService
{
    public function __construct(
        protected ExchangeRateContract $exchangeRateService
    ) {}

    public function updateRate(): void
    {
        $this->exchangeRateService->latest();
    }
}
