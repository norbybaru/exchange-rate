<?php

namespace NorbyBaru\ExchangeRate;

use Illuminate\Support\ServiceProvider;
use NorbyBaru\ExchangeRate\Console\ExchangeRateCommand;
use NorbyBaru\ExchangeRate\Services\Contract\ExchangeRateContract;

class ExchangeRateServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishDatabase();
        $this->publishConfig();
        $this->registerCommands();
    }

    /**
     *  Register the application services...
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'exchange-rate');

        $this->app->bind(
            ExchangeRateContract::class,
            fn () => FactoryProvider::make(
                config: $this->app['config']->get('exchange-rate')
            )
        );

        $this->app->singleton(
            'Exchanger',
            fn () => new Exchanger(
                baseCurrency: strtoupper(
                    $this->app['config']->get('exchange-rate')['base_currency']
                )
            )
        );
    }

    protected function publishDatabase(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    $this->migrationPath().
                    '/create_exchange_rates_table.php' => database_path(
                        'migrations/'.
                            date('Y_m_d_His', time()).
                            '_create_exchange_rates_table.php'
                    ),
                    $this->migrationPath().
                    '/create_exchange_rate_histories_table.php' => database_path(
                        'migrations/'.
                            date('Y_m_d_His', time()).
                            '_create_exchange_rate_histories_table.php'
                    ),
                ],
                'exchange-rate-migration'
            );
        }
    }

    protected function configPath(): string
    {
        return __DIR__.'/../config/exchange-rate.php';
    }

    protected function migrationPath(): string
    {
        return __DIR__.'/../database/migrations';
    }

    protected function publishConfig(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    $this->configPath() => config_path('exchange-rate.php'),
                ],
                'exchange-rate-config'
            );
        }
    }

    public function registerCommands()
    {
        $this->commands([ExchangeRateCommand::class]);
    }
}
