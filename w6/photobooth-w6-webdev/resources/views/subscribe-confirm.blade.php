@extends('layouts.app')

@section('title', 'Confirm Subscription')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('services') }}" class="text-decoration-none">← Back to Trainer Plans</a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="poke-card shadow-lg p-4 p-md-5">
                        <div class="text-center mb-4">
                            <span class="badge bg-warning text-dark fw-bold mb-2">Confirm Your Plan</span>
                            <h1 class="brand-font display-6 section-title mb-1">{{ $plan['name'] }}</h1>
                            <p class="text-muted mb-0">Review the details below before placing your order</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-7">
                                <h5 class="fw-bold mb-3">What you get</h5>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($plan['features'] as $i => $feature)
                                        <li class="py-2 {{ $i < count($plan['features']) - 1 ? 'border-bottom' : '' }}">
                                            <span class="text-poke-red fw-bold me-2">&#10004;</span>{{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="p-3 rounded" style="background: #fff5f5; border: 2px solid #ee1515;">
                                    <h5 class="fw-bold mb-3">Order summary</h5>
                                    <dl class="mb-3">
                                        <dt class="small text-muted">Plan</dt>
                                        <dd class="fw-bold">{{ $plan['name'] }}</dd>

                                        <dt class="small text-muted">Trainer</dt>
                                        <dd>{{ Auth::user()->name }}<div class="small text-muted">{{ Auth::user()->email }}</div></dd>

                                        <dt class="small text-muted">Billing cycle</dt>
                                        <dd>{{ $plan['duration_days'] }} days{{ $plan['duration_label'] }}</dd>

                                        <dt class="small text-muted">Active until</dt>
                                        <dd>{{ $endsAt->format('d M Y') }}</dd>
                                    </dl>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Total today</span>
                                        <span class="h4 fw-bold text-poke-red mb-0">Rp {{ number_format($plan['price'], 0, ',', '.') }}</span>
                                    </div>

                                    <form method="POST" action="{{ route('subscription.subscribe', $planKey) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-poke btn-lg w-100 mb-2">Place Order</button>
                                    </form>
                                    <a href="{{ route('services') }}" class="btn btn-outline-dark w-100">Cancel</a>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4 mb-0 small">
                            <strong>Heads up:</strong> after confirming, your order will be created with status <strong>pending</strong> until payment via Midtrans is completed.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
