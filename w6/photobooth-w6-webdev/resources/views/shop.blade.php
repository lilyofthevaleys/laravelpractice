@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold section-title">Poké Shop</h1>
                <p class="lead text-muted">Pokémon, Poké Balls, Berries, Medicines, and more — everything a trainer needs</p>
                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.shop.index') }}" class="btn btn-outline-dark mt-2">Manage Shop (Admin)</a>
                    @endif
                @endauth
            </div>

            {{-- Filter pills --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                @foreach ($filters as $key => $label)
                    <a href="{{ route('shop', ['category' => $key]) }}"
                       class="btn {{ $category === $key ? 'btn-poke' : 'btn-poke-outline' }} btn-sm px-3">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($pokemons->isEmpty() && $items->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted">No products in this category yet.</p>
                </div>
            @endif

            <div class="row g-4">
                {{-- Pokémon cards --}}
                @foreach ($pokemons as $pokemon)
                    @php
                        $typeColors = [
                            'Fire'     => ['bg' => '#ee8130', 'fg' => '#fff'],
                            'Water'    => ['bg' => '#6390f0', 'fg' => '#fff'],
                            'Grass'    => ['bg' => '#7ac74c', 'fg' => '#fff'],
                            'Electric' => ['bg' => '#f7d02c', 'fg' => '#222'],
                            'Fairy'    => ['bg' => '#d685ad', 'fg' => '#fff'],
                            'Normal'   => ['bg' => '#a8a77a', 'fg' => '#fff'],
                            'Ghost'    => ['bg' => '#735797', 'fg' => '#fff'],
                            'Psychic'  => ['bg' => '#f95587', 'fg' => '#fff'],
                            'Dragon'   => ['bg' => '#6f35fc', 'fg' => '#fff'],
                            'Rock'     => ['bg' => '#b6a136', 'fg' => '#fff'],
                            'Ground'   => ['bg' => '#e2bf65', 'fg' => '#222'],
                            'Ice'      => ['bg' => '#96d9d6', 'fg' => '#222'],
                            'Bug'      => ['bg' => '#a6b91a', 'fg' => '#fff'],
                            'Flying'   => ['bg' => '#a98ff3', 'fg' => '#fff'],
                            'Fighting' => ['bg' => '#c22e28', 'fg' => '#fff'],
                            'Poison'   => ['bg' => '#a33ea1', 'fg' => '#fff'],
                            'Steel'    => ['bg' => '#b7b7ce', 'fg' => '#222'],
                            'Dark'     => ['bg' => '#705746', 'fg' => '#fff'],
                        ];
                        $color = $typeColors[$pokemon->type] ?? ['bg' => '#888', 'fg' => '#fff'];
                        $isUrl = $pokemon->image_path && str_starts_with($pokemon->image_path, 'http');
                        $img = $pokemon->image_path
                            ? ($isUrl ? $pokemon->image_path : asset($pokemon->image_path))
                            : 'https://placehold.co/400x300?text=' . urlencode($pokemon->name);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card shadow-sm position-relative">
                            @if ($pokemon->is_best_seller)
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 fw-bold shadow-sm" style="border: 1px solid #1a1a1a; z-index: 2;">★ Best Seller</span>
                            @endif
                            @auth
                                @if (! Auth::user()->isAdmin())
                                    @php $isFav = $favouritedPokemonIds->contains($pokemon->id); @endphp
                                    <form method="POST" action="{{ route('favourites.toggle', ['pokemon', $pokemon->id]) }}" class="position-absolute" style="top: 8px; left: 8px; z-index: 2;">
                                        @csrf
                                        <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px; border: 1px solid #1a1a1a;" title="{{ $isFav ? 'Remove from favourites' : 'Add to favourites' }}">
                                            <i class="bi bi-heart{{ $isFav ? '-fill text-poke-red' : '' }}"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-circle shadow-sm position-absolute d-flex align-items-center justify-content-center p-0" style="top: 8px; left: 8px; z-index: 2; width: 36px; height: 36px; border: 1px solid #1a1a1a;" title="Log in to favourite">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endauth
                            <div class="d-flex justify-content-center align-items-center" style="background: #f4f4f4; height: 220px;">
                                <img src="{{ $img }}" alt="{{ $pokemon->name }}" style="max-height: 200px; max-width: 90%; object-fit: contain;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="card-title mb-0 fw-bold">{{ $pokemon->name }}</h4>
                                    <span class="poke-badge-hp">HP {{ $pokemon->hp }}</span>
                                </div>
                                <span class="badge mb-2 align-self-start" style="background: {{ $color['bg'] }}; color: {{ $color['fg'] }};">{{ $pokemon->type }}</span>
                                <p class="card-text flex-grow-1 small text-muted">{{ $pokemon->details }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h5 mb-0 text-poke-red fw-bold">Rp {{ number_format($pokemon->price, 0, ',', '.') }}</span>
                                    @if ($pokemon->stock > 0)
                                        <span class="small text-muted">{{ $pokemon->stock }} in stock</span>
                                    @else
                                        <span class="badge bg-dark">Sold Out</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    @if (Auth::check() && Auth::user()->isAdmin())
                                        <a href="{{ route('admin.shop.edit', $pokemon) }}" class="btn btn-outline-dark btn-sm flex-grow-1">Edit in Dashboard</a>
                                    @else
                                        <form method="POST" action="{{ route('cart.add', ['pokemon', $pokemon->id]) }}" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-poke btn-sm w-100" {{ $pokemon->stock > 0 ? '' : 'disabled' }}>
                                                {{ $pokemon->stock > 0 ? 'Add to Cart' : 'Sold Out' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Item cards (Poké Balls / Berries / Medicines / General) --}}
                @foreach ($items as $item)
                    @php
                        $categoryColors = [
                            'pokeball' => ['bg' => '#ee1515', 'fg' => '#fff'],
                            'berry'    => ['bg' => '#a33ea1', 'fg' => '#fff'],
                            'medicine' => ['bg' => '#6390f0', 'fg' => '#fff'],
                            'general'  => ['bg' => '#705746', 'fg' => '#fff'],
                        ];
                        $cat = $categoryColors[$item->category] ?? ['bg' => '#888', 'fg' => '#fff'];
                        $isUrlItem = $item->image_path && str_starts_with($item->image_path, 'http');
                        $imgItem = $item->image_path
                            ? ($isUrlItem ? $item->image_path : asset($item->image_path))
                            : 'https://placehold.co/400x300?text=' . urlencode($item->name);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card shadow-sm position-relative">
                            @if ($item->is_best_seller)
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 fw-bold shadow-sm" style="border: 1px solid #1a1a1a; z-index: 2;">★ Best Seller</span>
                            @endif
                            @auth
                                @if (! Auth::user()->isAdmin())
                                    @php $isFav = $favouritedItemIds->contains($item->id); @endphp
                                    <form method="POST" action="{{ route('favourites.toggle', ['item', $item->id]) }}" class="position-absolute" style="top: 8px; left: 8px; z-index: 2;">
                                        @csrf
                                        <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px; border: 1px solid #1a1a1a;" title="{{ $isFav ? 'Remove from favourites' : 'Add to favourites' }}">
                                            <i class="bi bi-heart{{ $isFav ? '-fill text-poke-red' : '' }}"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-circle shadow-sm position-absolute d-flex align-items-center justify-content-center p-0" style="top: 8px; left: 8px; z-index: 2; width: 36px; height: 36px; border: 1px solid #1a1a1a;" title="Log in to favourite">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endauth
                            <div class="d-flex justify-content-center align-items-center" style="background: #f4f4f4; height: 220px;">
                                <img src="{{ $imgItem }}" alt="{{ $item->name }}" style="height: 180px; width: auto; object-fit: contain; image-rendering: pixelated; image-rendering: -moz-crisp-edges; image-rendering: crisp-edges;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title fw-bold mb-2">{{ $item->name }}</h4>
                                <span class="badge mb-2 align-self-start" style="background: {{ $cat['bg'] }}; color: {{ $cat['fg'] }};">{{ $item->categoryLabel() }}</span>
                                <p class="card-text flex-grow-1 small text-muted">{{ $item->details }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h5 mb-0 text-poke-red fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    @if ($item->stock > 0)
                                        <span class="small text-muted">{{ $item->stock }} in stock</span>
                                    @else
                                        <span class="badge bg-dark">Sold Out</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    @if (Auth::check() && Auth::user()->isAdmin())
                                        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-outline-dark btn-sm flex-grow-1">Edit in Dashboard</a>
                                    @else
                                        <form method="POST" action="{{ route('cart.add', ['item', $item->id]) }}" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-poke btn-sm w-100" {{ $item->stock > 0 ? '' : 'disabled' }}>
                                                {{ $item->stock > 0 ? 'Add to Cart' : 'Sold Out' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
