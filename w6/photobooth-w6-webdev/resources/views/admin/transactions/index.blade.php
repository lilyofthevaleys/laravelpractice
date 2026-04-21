@extends('layouts.admin')

@section('title', 'Transactions')
@section('heading', 'Transactions')
@section('subheading', 'Every order placed through Pokémart')

@section('content')
    <div class="admin-card p-3 p-md-4">
        @if ($transactions->isEmpty())
            <div class="text-center text-muted py-5">No transactions yet.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                            <tr>
                                <td class="fw-bold">{{ $t->order_code }}</td>
                                <td>
                                    {{ $t->user->name ?? '—' }}
                                    <div class="small text-muted">{{ $t->user->email ?? '' }}</div>
                                </td>
                                <td>{{ $t->items->sum('quantity') }}</td>
                                <td class="fw-bold">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                <td><span class="badge-status badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                                <td class="text-muted small">{{ $t->created_at->format('d M Y, H:i') }}</td>
                                <td><a href="{{ route('admin.transactions.show', $t) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $transactions->links() }}</div>
        @endif
    </div>
@endsection
