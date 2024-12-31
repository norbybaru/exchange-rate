<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate\Console;

use Illuminate\Console\Command;
use NorbyBaru\ExchangeRate\Services\ExchangeRatesRequestService;

class ExchangeRateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Exchange rate to get latest one from third party';

    public function handle(ExchangeRatesRequestService $exchangeRateRequest)
    {
        $this->info('Processing Exchange Rate updates...');

        $exchangeRateRequest->updateRate();

        $this->info('Exchange Rate updated successfully');
    }
}
