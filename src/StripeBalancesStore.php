<?php

namespace Digikraaft\StripeBalancesTile;

use Spatie\Dashboard\Models\Tile;

class StripeBalancesStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("stripeBalances");
    }

    public function setData(array $data): self
    {
        $this->tile->putData('stripe.balances', $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData('stripe.balances') ?? [];
    }
}
