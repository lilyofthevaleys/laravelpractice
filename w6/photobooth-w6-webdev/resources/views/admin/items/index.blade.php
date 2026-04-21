@extends('layouts.admin')

@section('title', 'Manage Items')
@section('heading', 'Manage Items')
@section('subheading', 'Poké Balls, Berries, Medicines, and General Items')

@section('content')
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.shop.index') }}" class="btn btn-sm btn-outline-dark">← Pokémon</a>
        <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-dark">Items</a>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.items.index') }}"
               class="btn btn-sm {{ empty($activeCategory) ? 'btn-poke' : 'btn-poke-outline' }}">All</a>
            @foreach ($categoryLabels as $key => $label)
                <a href="{{ route('admin.items.index', ['category' => $key]) }}"
                   class="btn btn-sm {{ $activeCategory === $key ? 'btn-poke' : 'btn-poke-outline' }}">{{ $label }}</a>
            @endforeach
        </div>
        <a href="{{ route('admin.items.create') }}" class="btn btn-poke">+ Add Item</a>
    </div>

    <div class="admin-card p-3 p-md-4">
        @if ($items->isEmpty())
            <div class="text-center text-muted py-5">No items in this view. Add the first one!</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-center">Best Seller</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            @php
                                $isUrl = $item->image_path && str_starts_with($item->image_path, 'http');
                                $img = $item->image_path
                                    ? ($isUrl ? $item->image_path : asset($item->image_path))
                                    : 'https://placehold.co/64?text=' . urlencode($item->name);
                            @endphp
                            <tr>
                                <td><img src="{{ $img }}" alt="{{ $item->name }}" style="width:48px;height:48px;object-fit:contain;image-rendering:pixelated;"></td>
                                <td class="fw-bold">
                                    {{ $item->name }}
                                    @if ($item->is_best_seller)
                                        <span class="badge bg-warning text-dark ms-1" title="Best Seller">★</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-secondary">{{ $item->categoryLabel() }}</span></td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->stock > 0)
                                        <span class="text-muted">{{ $item->stock }}</span>
                                    @else
                                        <span class="badge-status badge-cancelled">Sold out</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.items.toggleBestSeller', $item) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $item->is_best_seller ? 'btn-warning' : 'btn-outline-warning' }}" title="{{ $item->is_best_seller ? 'Remove from Best Sellers' : 'Mark as Best Seller' }}">
                                            <i class="bi bi-star{{ $item->is_best_seller ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $items->links() }}</div>
        @endif
    </div>

    @foreach ($items as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete {{ $item->name }}?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        This will remove <strong>{{ $item->name }}</strong> from the shop.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
