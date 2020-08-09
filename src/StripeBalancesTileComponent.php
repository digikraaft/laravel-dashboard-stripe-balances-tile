<?php

namespace Digikraaft\StripeBalancesTile;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class StripeBalancesTileComponent extends Component
{
    use WithPagination;

    /** @var string */
    public string $position;

    /** @var string|null */
    public ?string $title;

    public $perPage;

    /** @var int|null */
    public ?int $refreshInSeconds;

    public function mount(string $position, $perPage = 5, ?string $title = null, int $refreshInSeconds = null)
    {
        $this->position = $position;
        $this->perPage = $perPage;
        $this->title = $title;
        $this->refreshInSeconds = $refreshInSeconds;
    }

    public function render()
    {
        $balances = collect(StripeBalancesStore::make()->getData());
        $paginator = $this->getPaginator($balances);

        return view('dashboard-stripe-balances-tile::tile', [
            'balances' => $balances->skip(($paginator->firstItem() ?? 1) - 1)->take($paginator->perPage()),
            'paginator' => $paginator,
            'refreshIntervalInSeconds' => $this->refreshInSeconds ?? config('dashboard.tiles.stripe.balances.refresh_interval_in_seconds') ?? 1800,
        ]);
    }

    public function getPaginator(Collection $balances): LengthAwarePaginator
    {
        return new LengthAwarePaginator($balances, $balances->count(), $this->perPage, $this->page);
    }

    public function paginationView()
    {
        return 'dashboard-stripe-balances-tile::pagination';
    }
}
