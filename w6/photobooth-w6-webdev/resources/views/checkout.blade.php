@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <h1 class="fw-bold section-title mb-4">Checkout</h1>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="poke-card p-4">
                        <h5 class="fw-bold mb-3">Order summary</h5>
                        @foreach ($items as $item)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-bold">{{ $item['name'] }}</div>
                                    <div class="small text-muted">Qty {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                </div>
                                <div class="fw-bold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between fs-5 fw-bold text-poke-red mt-3">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="poke-card p-4">
                        <h5 class="fw-bold mb-3">Payment</h5>
                        <p class="text-muted">Payments are handled by <strong>Midtrans</strong> Snap (coming soon). For now, submitting creates a pending order you can view in your account.</p>
                        <form method="POST" action="{{ route('checkout.process') }}">
                            @csrf
                            <button class="btn btn-poke btn-lg w-100">Place Order</button>
                        </form>
                        <a href="{{ route('cart.index') }}" class="btn btn-link w-100 mt-2">← Back to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
