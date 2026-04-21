@extends('layouts.admin')

@section('title', 'Manage Pokémon')
@section('heading', 'Manage Pokémon')
@section('subheading', 'Add, edit, and release Pokémon from the store')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.shop.index') }}" class="btn btn-sm btn-dark">Pokémon</a>
            <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-outline-dark">Items →</a>
        </div>
        <a href="{{ route('admin.shop.create') }}" class="btn btn-poke">+ Add Pokémon</a>
    </div>

    <div class="admin-card p-3 p-md-4">
        @if ($pokemons->isEmpty())
            <div class="text-center text-muted py-5">No Pokémon yet. Add the first one!</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>HP</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-center">Best Seller</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pokemons as $p)
                            @php
                                $isUrl = $p->image_path && str_starts_with($p->image_path, 'http');
                                $img = $p->image_path
                                    ? ($isUrl ? $p->image_path : asset($p->image_path))
                                    : 'https://placehold.co/64?text=' . urlencode($p->name);
                            @endphp
                            <tr>
                                <td><img src="{{ $img }}" alt="{{ $p->name }}" style="width:48px;height:48px;object-fit:contain;"></td>
                                <td class="fw-bold">
                                    {{ $p->name }}
                                    @if ($p->is_best_seller)
                                        <span class="badge bg-warning text-dark ms-1" title="Best Seller">★</span>
                                    @endif
                                </td>
                                <td>{{ $p->type }}</td>
                                <td>{{ $p->hp }}</td>
                                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($p->stock > 0)
                                        <span class="text-muted">{{ $p->stock }}</span>
                                    @else
                                        <span class="badge-status badge-cancelled">Sold out</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.shop.toggleBestSeller', $p) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $p->is_best_seller ? 'btn-warning' : 'btn-outline-warning' }}" title="{{ $p->is_best_seller ? 'Remove from Best Sellers' : 'Mark as Best Seller' }}">
                                            <i class="bi bi-star{{ $p->is_best_seller ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.shop.edit', $p) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $p->id }}">Release</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $pokemons->links() }}</div>
        @endif
    </div>

    @foreach ($pokemons as $p)
        <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Release {{ $p->name }}?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        This will remove <strong>{{ $p->name }}</strong> from the shop.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.shop.destroy', $p) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Release</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
