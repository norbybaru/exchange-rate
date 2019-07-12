<?php namespace NorbyBaru\ExchangeRate\Commands;



use Illuminate\Console\Command;
use NorbyBaru\ExchangeRate\Services\ExchangeRatesRequestService;

/**
 * Class ExchangeRateCommand
 * @package NorbyBaru\ExchangeRate\Commands
 */
class ExchangeRateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "rate:update";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update Exchange rate to get latest one from third party";

    public function handle(ExchangeRatesRequestService $requestService)
    {
        $this->info("Starting Rate update...");

        $requestService->latest();
    }
}
