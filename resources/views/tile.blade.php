<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid gap-2 justify-items-center text-center h-auto">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }} <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @else
            <h1 class="font-bold">
               Stripe Balances <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @endisset
        <ul class="self-center divide-y-2 divide-canvas">
            @foreach($balances as $balance)
                <li class="py-1">
                    <div class="my-2">
                        <div class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums">
                            {{$balance['currency']}}
                        </div>
                        <div class="font-bold">
                            <span class="{{ ($balance['amount'] < 0)? 'text-red-700' : 'text-green-700' }} text-4xl tracking-wide leading-none">
                                {{ $balance['amount'] }}
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{$paginator}}
    </div>
</x-dashboard-tile>
