@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <h1 class="fw-bold section-title mb-4">Your Bag</h1>

            @if (empty($items))
                <div class="poke-card p-5 text-center">
                    <p class="lead mb-3">Your bag is empty. Go catch something!</p>
                    <a href="{{ route('shop') }}" class="btn btn-poke">Browse the Shop</a>
                </div>
            @else
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="poke-card p-3 p-md-4">
                            @foreach ($items as $item)
                                @php
                                    $isUrl = $item['image_path'] && str_starts_with($item['image_path'], 'http');
                                    $img = $item['image_path']
                                        ? ($isUrl ? $item['image_path'] : asset($item['image_path']))
                                        : 'https://placehold.co/80?text=' . urlencode($item['name']);
                                @endphp
                                <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                                    <img src="{{ $img }}" alt="{{ $item['name'] }}" style="width:72px;height:72px;object-fit:contain;{{ $item['type'] === 'item' ? 'image-rendering:pixelated;' : '' }}">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fw-bold">{{ $item['name'] }}</h5>
                                        <div class="small text-muted mb-1 text-capitalize">{{ $item['type'] }}</div>
                                        <div class="text-poke-red fw-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                    </div>
                                    <form method="POST" action="{{ route('cart.update', [$item['type'], $item['id']]) }}" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" class="form-control form-control-sm" style="width:80px;">
                                        <button class="btn btn-sm btn-outline-dark">Update</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.remove', [$item['type'], $item['id']]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="poke-card p-4 sticky-top" style="top:90px;">
                            <h5 class="fw-bold mb-3">Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Shipping</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fs-5 fw-bold text-poke-red mb-3">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            @guest
                                <div class="alert py-2 small mb-2" style="background:#fff5f5;border:1px solid #ee1515;color:#a51818;">
                                    You'll need to log in to complete checkout.
                                </div>
                            @endguest
                            <a href="{{ route('checkout.show') }}" class="btn btn-poke btn-lg w-100 mb-2">
                                @guest Log in & Checkout @else Checkout @endguest
                            </a>
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-dark w-100">Clear Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
