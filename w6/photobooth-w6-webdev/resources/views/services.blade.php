@extends('layouts.app')

@section('title', 'Trainer Plans')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold section-title brand-font">Trainer Plans</h1>
                <p class="lead text-muted">Gear up, train up, and climb the ranks — choose your path to Champion</p>
            </div>

            @if (! empty($activeSub))
                <div class="alert alert-success border-2 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4" style="border-color:#198754;">
                    <div>
                        <i class="bi bi-patch-check-fill me-1"></i>
                        You're currently on the <strong>{{ $activeSub->plan_name }}</strong> plan —
                        active until <strong>{{ $activeSub->ends_at->format('d M Y') }}</strong>.
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
            @elseif (! empty($pendingSub))
                <div class="alert alert-warning border-2 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4" style="border-color:#ffc107;">
                    <div>
                        <i class="bi bi-hourglass-split me-1"></i>
                        Your <strong>{{ $pendingSub->plan_name }}</strong> subscription is awaiting payment.
                    </div>
                    <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="btn btn-sm btn-dark">Finish payment</a>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @foreach ($packages as $package)
                    @php
                        $isCurrent = ! empty($activePlanKey) && $activePlanKey === $package['key'];
                        $isPending = ! empty($pendingPlanKey) && $pendingPlanKey === $package['key'];
                        $hasAnyActive = ! empty($activeSub);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card {{ $package['is_popular'] ? 'shadow-lg' : 'shadow-sm' }}" style="{{ $isCurrent ? 'border-color: #198754; border-width: 3px;' : ($package['is_popular'] ? 'border-color: #ee1515; border-width: 3px;' : '') }}">
                            <div class="card-header text-center py-3 position-relative" style="background: {{ $isCurrent ? '#198754' : ($package['is_popular'] ? '#ee1515' : '#1a1a1a') }}; color: #fff;">
                                @if ($isCurrent)
                                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill px-3 py-2 shadow-sm" style="background:#ffffff;color:#198754;border:2px solid #1a1a1a;">✓ Your Plan</span>
                                @elseif ($package['is_popular'])
                                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill px-3 py-2 shadow-sm" style="background:#ffffff;color:#ee1515;border:2px solid #1a1a1a;">Most Popular</span>
                                @endif
                                <h4 class="my-0 fw-bold mt-2">{{ $package['name'] }}</h4>
                            </div>
                            <div class="card-body bg-white text-center d-flex flex-column">
                                <h1 class="card-title pricing-card-title h3 text-poke-red fw-bold">{{ $package['price_label'] }}<small class="text-muted fw-light fs-6">{{ $package['duration_label'] }}</small></h1>
                                <ul class="list-unstyled mt-3 mb-4 text-start">
                                    @foreach ($package['features'] as $index => $feature)
                                        <li class="py-2 {{ $index < count($package['features']) - 1 ? 'border-bottom' : '' }} text-dark">
                                            <span class="text-poke-red fw-bold me-2">&#10004;</span>{{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        <button type="button" class="w-100 btn btn-lg btn-secondary mt-auto" disabled title="Admins can't subscribe">Admin Account</button>
                                    @elseif ($isCurrent)
                                        <button type="button" class="w-100 btn btn-lg btn-success mt-auto" disabled>Current Plan</button>
                                    @elseif ($isPending)
                                        <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="w-100 btn btn-lg btn-warning text-dark mt-auto">Finish Payment</a>
                                    @elseif ($hasAnyActive)
                                        <button type="button" class="w-100 btn btn-lg btn-outline-secondary mt-auto" disabled title="Active plan: {{ $activeSub->plan_name }}">Already subscribed</button>
                                    @else
                                        <a href="{{ route('subscription.confirm', $package['key']) }}" class="w-100 btn btn-lg {{ $package['is_popular'] ? 'btn-poke' : 'btn-poke-outline' }} mt-auto">{{ $package['btn_text'] }}</a>
                                    @endif
                                @else
                                    <a href="{{ route('subscription.confirm', $package['key']) }}" class="w-100 btn btn-lg {{ $package['is_popular'] ? 'btn-poke' : 'btn-poke-outline' }} mt-auto">{{ $package['btn_text'] }}</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5 pt-3">
                <p class="text-muted mb-0">All plans include a free Pokédex and a welcome kit signed by Professor Oak.</p>
            </div>
        </div>
    </main>
@endsection
