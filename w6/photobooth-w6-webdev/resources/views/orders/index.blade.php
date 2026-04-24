@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    @php
        $statusClasses = [
            \App\Models\Transaction::STATUS_PENDING   => 'bg-warning text-dark',
            \App\Models\Transaction::STATUS_PAID      => 'bg-success text-white',
            \App\Models\Transaction::STATUS_FAILED    => 'bg-danger text-white',
            \App\Models\Transaction::STATUS_CANCELLED => 'bg-secondary text-white',
        ];
    @endphp
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="fw-bold section-title mb-1">My Orders</h1>
                    <p class="text-muted mb-0">Your order history and ongoing payments</p>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-poke-outline">← Back to Shop</a>
            </div>

            @php
                $filterOptions = [
                    null                                              => ['label' => 'All',       'badge' => 'bg-dark text-white'],
                    \App\Models\Transaction::STATUS_PENDING           => ['label' => 'Pending',   'badge' => 'bg-warning text-dark'],
                    \App\Models\Transaction::STATUS_PAID              => ['label' => 'Paid',      'badge' => 'bg-success text-white'],
                    \App\Models\Transaction::STATUS_FAILED            => ['label' => 'Failed',    'badge' => 'bg-danger text-white'],
                    \App\Models\Transaction::STATUS_CANCELLED         => ['label' => 'Cancelled', 'badge' => 'bg-secondary text-white'],
                ];
                $totalCount = $counts->sum();
            @endphp
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach ($filterOptions as $key => $opt)
                    @php
                        $count = $key === null ? $totalCount : ($counts[$key] ?? 0);
                        $active = $status === $key;
                    @endphp
                    <a href="{{ $key === null ? route('orders.index') : route('orders.index', ['status' => $key]) }}"
                       class="btn btn-sm {{ $active ? 'btn-poke' : 'btn-poke-outline' }} px-3 d-inline-flex align-items-center gap-2">
                        {{ $opt['label'] }}
                        <span class="badge rounded-pill {{ $active ? 'bg-light text-poke-red' : $opt['badge'] }}">{{ $count }}</span>
                    </a>
                @endforeach
            </div>

            <div class="poke-card p-3 p-md-4">
                @if ($transactions->isEmpty())
                    <div class="text-center py-5">
                        <span class="pokeball d-inline-block mb-3" style="width:54px;height:54px;"></span>
                        @if ($status)
                            <h4 class="fw-bold mb-2">No {{ $status }} orders</h4>
                            <p class="text-muted mb-3">Nothing here yet — try a different filter.</p>
                            <a href="{{ route('orders.index') }}" class="btn btn-poke-outline">Show all orders</a>
                        @else
                            <h4 class="fw-bold mb-2">No orders yet</h4>
                            <p class="text-muted mb-3">You haven't placed any orders. Go catch something!</p>
                            <a href="{{ route('shop') }}" class="btn btn-poke">Enter the Shop</a>
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Order</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Placed</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $t)
                                    @php
                                        $isPending = $t->status === \App\Models\Transaction::STATUS_PENDING;
                                        $badgeClass = $statusClasses[$t->status] ?? 'bg-secondary text-white';
                                    @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $t->order_code }}</td>
                                        <td>
                                            {{ $t->items->sum('quantity') }}
                                            <div class="small text-muted">
                                                {{ $t->items->take(2)->pluck('name')->join(', ') }}@if ($t->items->count() > 2) …@endif
                                            </div>
                                        </td>
                                        <td class="fw-bold text-poke-red">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst($t->status) }}</span>
                                        </td>
                                        <td class="text-muted small">{{ $t->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-end">
                                            @if ($isPending)
                                                <div class="d-inline-flex gap-1">
                                                    <a href="{{ route('checkout.pending', $t) }}" class="btn btn-sm btn-poke">Pay now</a>
                                                    <form method="POST" action="{{ route('orders.cancel', $t) }}" class="m-0" onsubmit="return confirm('Cancel order {{ $t->order_code }}? This cannot be undone.');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                                    </form>
                                                </div>
                                            @else
                                                <a href="{{ route('checkout.pending', $t) }}" class="btn btn-sm btn-outline-dark">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $transactions->links() }}</div>
                @endif
            </div>
        </div>
    </main>
@endsection
