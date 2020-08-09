<?php

namespace Digikraaft\StripeBalancesTile;

use Illuminate\Console\Command;
use Stripe\Balance;
use Stripe\Stripe;

class FetchBalancesDataFromStripeApi extends Command
{
    protected $signature = 'dashboard:fetch-balances-data-from-stripe-api';

    protected $description = 'Fetch data for Stripe balances tile';

    public function handle()
    {
        Stripe::setApiKey(
            config('dashboard.tiles.stripe.secret_key', env('STRIPE_SECRET'))
        );

        $this->info('Fetching Stripe balances ...');

        $balances = Balance::retrieve();

        $balances = collect($balances->available)
            ->map(function ($balance) {
                return [
                    'amount' => $this->toReadableAmount($balance->amount),
                    'currency' => strtoupper($balance->currency),
                ];
            })->toArray();

        StripeBalancesStore::make()->setData($balances);

        $this->info('All done!');

        return 0;
    }

    public function toReadableAmount($baseAmount)
    {
        return $baseAmount / 100;
    }
}
