<?php

namespace Modules\Exchange\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Modules\Exchange\Asset\Ingest\CoinbaseAssetInformationProvider;
use Modules\Exchange\Asset\Ingest\CryptoAssetInformationProvider;
use Modules\Exchange\Asset\Ingest\RefreshCryptoPricesCommand;

class ExchangeServiceProvider extends AggregateServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->app->bind(CryptoAssetInformationProvider::class, fn () => new CoinbaseAssetInformationProvider());
        $this->commands([RefreshCryptoPricesCommand::class]);

        parent::register();
    }
}
