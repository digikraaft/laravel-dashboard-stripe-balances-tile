<?php

namespace Digikraaft\StripeBalancesTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class StripeBalancesTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchBalancesDataFromStripeApi::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/stripe-balances-tile'),
        ], 'stripe-balances-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-stripe-balances-tile');

        Livewire::component('stripe-balances-tile', StripeBalancesTileComponent::class);
    }
}
