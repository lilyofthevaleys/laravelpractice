@extends('layouts.app')

@section('title', 'Order ' . $transaction->order_code)

@section('content')
    @php
        $status     = $transaction->status;
        $isPending  = $status === \App\Models\Transaction::STATUS_PENDING;
        $isPaid     = $status === \App\Models\Transaction::STATUS_PAID;
        $isFailed   = in_array($status, [\App\Models\Transaction::STATUS_FAILED, \App\Models\Transaction::STATUS_CANCELLED], true);
        $snapReady  = $isPending && \App\Services\Midtrans::configured() && $transaction->snap_token;
    @endphp
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="poke-card p-4 p-md-5 text-center">
                        <span class="pokeball d-inline-block mb-3" style="width:64px;height:64px;"></span>

                        @if ($isPaid)
                            <h2 class="fw-bold section-title mb-2">Payment Received</h2>
                            <p class="text-muted mb-4">Thanks! Order <strong>{{ $transaction->order_code }}</strong> is paid and being prepared.</p>
                        @elseif ($isFailed)
                            <h2 class="fw-bold section-title mb-2">Payment {{ ucfirst($status) }}</h2>
                            <p class="text-muted mb-4">Order <strong>{{ $transaction->order_code }}</strong> did not complete. You can try again from the shop.</p>
                        @else
                            <h2 class="fw-bold section-title mb-2">Complete Payment</h2>
                            <p class="text-muted mb-4">Order <strong>{{ $transaction->order_code }}</strong> is awaiting payment.</p>
                        @endif

                        <dl class="row text-start mb-4">
                            <dt class="col-5">Total</dt>
                            <dd class="col-7 fw-bold text-poke-red">Rp {{ number_format($transaction->total, 0, ',', '.') }}</dd>
                            <dt class="col-5">Status</dt>
                            <dd class="col-7">{{ ucfirst($status) }}</dd>
                            <dt class="col-5">Payment method</dt>
                            <dd class="col-7">{{ ucfirst($transaction->payment_method ?? '—') }}</dd>
                            @if ($transaction->paid_at)
                                <dt class="col-5">Paid at</dt>
                                <dd class="col-7">{{ $transaction->paid_at->format('d M Y, H:i') }}</dd>
                            @endif
                        </dl>

                        @if ($snapReady)
                            <button type="button" id="pay-button" class="btn btn-poke btn-lg w-100 mb-2">Pay</button>
                            <a href="{{ route('shop') }}" class="btn btn-link w-100 mb-2">Continue shopping</a>
                        @elseif ($isPending && ! \App\Services\Midtrans::configured())
                            <div class="alert alert-warning text-start small mb-3">
                                Midtrans isn't configured yet. Set <code>MIDTRANS_SERVER_KEY</code> and <code>MIDTRANS_CLIENT_KEY</code> in <code>.env</code> — the Pay button will show up here.
                            </div>
                            <a href="{{ route('shop') }}" class="btn btn-poke w-100 mb-2">Continue Shopping</a>
                        @elseif ($isPending)
                            <div class="alert alert-danger text-start small mb-3">
                                We couldn't prepare the payment session. Please try again in a moment or contact support.
                            </div>
                            <a href="{{ route('shop') }}" class="btn btn-poke w-100 mb-2">Continue Shopping</a>
                        @else
                            <a href="{{ route('shop') }}" class="btn btn-poke w-100">Continue Shopping</a>
                        @endif

                        @if ($isPending)
                            <form method="POST" action="{{ route('orders.cancel', $transaction) }}" class="mt-2" onsubmit="return confirm('Cancel this order? This cannot be undone.');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">Cancel order</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if ($snapReady)
        <script src="{{ \App\Services\Midtrans::snapJsUrl() }}"
                data-client-key="{{ \App\Services\Midtrans::clientKey() }}"></script>
        <script>
            (function () {
                const btn = document.getElementById('pay-button');
                if (!btn || typeof window.snap === 'undefined') return;

                const token = @json($transaction->snap_token);
                const redirectUrl = @json(route('checkout.pending', $transaction));

                btn.addEventListener('click', function () {
                    btn.disabled = true;
                    window.snap.pay(token, {
                        onSuccess:  function () { window.location.href = redirectUrl; },
                        onPending:  function () { window.location.href = redirectUrl; },
                        onError:    function () { btn.disabled = false; alert('Payment failed. Please try again.'); },
                        onClose:    function () { btn.disabled = false; },
                    });
                });
            })();
        </script>
    @endif
@endsection
