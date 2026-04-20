@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold section-title">Poké Shop</h1>
                <p class="lead text-muted">Gotta buy 'em all — our current roster of trainers' companions</p>
                <a href="{{ route('pokemon.create') }}" class="btn btn-poke mt-2">+ Add Pokémon</a>
            </div>

            <div class="row g-4">
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
                        <div class="card h-100 poke-card shadow-sm">
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
                                    <a href="{{ route('pokemon.edit', $pokemon) }}" class="btn btn-poke-outline btn-sm flex-grow-1">Edit</a>
                                    <button type="button" class="btn btn-outline-dark btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pokemon->id }}">Release</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{ $pokemon->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-poke-red">
                                    <h5 class="modal-title">Release {{ $pokemon->name }}?</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    This will permanently remove <strong>{{ $pokemon->name }}</strong> from the shop.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('pokemon.destroy', $pokemon) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-poke">Release</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
