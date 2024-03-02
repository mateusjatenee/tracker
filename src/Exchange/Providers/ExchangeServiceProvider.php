<?php

namespace Modules\Exchange\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ExchangeServiceProvider extends AggregateServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        parent::register();
    }
}
