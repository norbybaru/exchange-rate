<?php namespace NorbyBaru\ExchangeRate;

use Illuminate\Support\ServiceProvider;
use NorbyBaru\ExchangeRate\Commands\ExchangeRateCommand;

/**
 * Class ExchangeRateServiceProvider
 * @package NorbyBaru\ExchangeRate
 */
class ExchangeRateServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrations();
        $this->publishConfig();
        $this->registerCommands();
    }

    /**
     *  Register the application services...
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'exchange');

        $this->app->singleton('Exchange', function () {
            return new Exchange($this->app['config']->get('exchange'));
        });
    }

    /**
     * Load migration files
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Return config file
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/exchange.php';
    }

    /**
     * Publish config file
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->configPath() => config_path('exchange.php')
        ]);
    }

    public function registerCommands()
    {
        $this->commands([
            ExchangeRateCommand::class
        ]);
    }
}
