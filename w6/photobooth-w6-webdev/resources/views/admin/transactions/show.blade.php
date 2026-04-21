@extends('layouts.admin')

@section('title', 'Transaction ' . $transaction->order_code)
@section('heading', 'Order ' . $transaction->order_code)
@section('subheading', $transaction->created_at->format('d M Y, H:i'))

@section('content')
    <div class="mb-3"><a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">← Back to transactions</a></div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card p-3 p-md-4">
                <h5 class="fw-bold mb-3">Items</h5>
                <table class="table align-middle">
                    <thead class="small text-muted text-uppercase">
                        <tr><th>Item</th><th>Qty</th><th>Unit</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><th colspan="3" class="text-end">Total</th><th>Rp {{ number_format($transaction->total, 0, ',', '.') }}</th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card p-3 p-md-4">
                <h5 class="fw-bold mb-3">Details</h5>
                <dl class="mb-0">
                    <dt class="small text-muted">Customer</dt>
                    <dd>{{ $transaction->user->name ?? '—' }}<br><span class="small text-muted">{{ $transaction->user->email ?? '' }}</span></dd>

                    <dt class="small text-muted">Status</dt>
                    <dd><span class="badge-status badge-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></dd>

                    <dt class="small text-muted">Payment method</dt>
                    <dd>{{ $transaction->payment_method ?? '—' }}</dd>

                    <dt class="small text-muted">Midtrans ID</dt>
                    <dd class="small">{{ $transaction->midtrans_order_id ?? '—' }}</dd>

                    <dt class="small text-muted">Paid at</dt>
                    <dd>{{ $transaction->paid_at ? $transaction->paid_at->format('d M Y, H:i') : '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
