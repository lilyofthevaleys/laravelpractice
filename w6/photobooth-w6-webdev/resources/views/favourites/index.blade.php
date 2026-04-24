@extends('layouts.app')

@section('title', 'My Favourites')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="fw-bold section-title mb-1"><i class="bi bi-heart-fill text-poke-red me-2"></i>My Favourites</h1>
                    <p class="text-muted mb-0">Pokémon and items you've bookmarked</p>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-poke-outline">← Back to Shop</a>
            </div>

            @if ($favourites->isEmpty())
                <div class="poke-card p-5 text-center">
                    <i class="bi bi-heart" style="font-size: 3rem; color: #ccc;"></i>
                    <h4 class="fw-bold mt-3 mb-2">No favourites yet</h4>
                    <p class="text-muted mb-3">Tap the ♥ on any product to save it here.</p>
                    <a href="{{ route('shop') }}" class="btn btn-poke">Browse the Shop</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($favourites as $fav)
                        @php
                            $buyable = $fav->favouritable;
                            if (! $buyable) continue;
                            $isPokemon = $buyable instanceof \App\Models\Pokemon;
                            $type = $isPokemon ? 'pokemon' : 'item';
                            $isUrl = $buyable->image_path && str_starts_with($buyable->image_path, 'http');
                            $img = $buyable->image_path
                                ? ($isUrl ? $buyable->image_path : asset($buyable->image_path))
                                : 'https://placehold.co/400x300?text=' . urlencode($buyable->name);
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 poke-card shadow-sm position-relative">
                                <form method="POST" action="{{ route('favourites.toggle', [$type, $buyable->id]) }}" class="position-absolute" style="top: 8px; left: 8px; z-index: 2;">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px; border: 1px solid #1a1a1a;" title="Remove from favourites">
                                        <i class="bi bi-heart-fill text-poke-red"></i>
                                    </button>
                                </form>
                                <div class="d-flex justify-content-center align-items-center" style="background: #f4f4f4; height: 200px;">
                                    <img src="{{ $img }}" alt="{{ $buyable->name }}" style="max-height: 180px; max-width: 90%; object-fit: contain;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold mb-0">{{ $buyable->name }}</h5>
                                        @if ($isPokemon)
                                            <span class="poke-badge-hp">HP {{ $buyable->hp }}</span>
                                        @endif
                                    </div>
                                    <span class="badge align-self-start mb-2 bg-dark">
                                        {{ $isPokemon ? $buyable->type : $buyable->categoryLabel() }}
                                    </span>
                                    <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($buyable->details, 90) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="h6 mb-0 text-poke-red fw-bold">Rp {{ number_format($buyable->price, 0, ',', '.') }}</span>
                                        <a href="{{ route('shop') }}" class="btn btn-poke-outline btn-sm">View in Shop</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $favourites->links() }}</div>
            @endif
        </div>
    </main>
@endsection
