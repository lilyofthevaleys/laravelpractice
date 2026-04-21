@extends('layouts.admin')

@php
    $isEdit = $item->exists;
    $action = $isEdit ? route('admin.items.update', $item) : route('admin.items.store');
    $title = $isEdit ? 'Edit ' . $item->name : 'Add Item';
@endphp

@section('title', $title)
@section('heading', $title)
@section('subheading', $isEdit ? 'Update details for this item' : 'Add a new item to the shop')

@section('content')
    <div class="mb-3"><a href="{{ route('admin.items.index') }}" class="text-decoration-none">← Back to items</a></div>

    <div class="admin-card p-3 p-md-4" style="max-width: 780px;">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="category" class="form-label fw-bold">Category</label>
                    <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="">-- choose --</option>
                        @foreach (\App\Models\Item::CATEGORY_LABELS as $key => $label)
                            <option value="{{ $key }}" @selected(old('category', $item->category) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label fw-bold">Price (Rp)</label>
                    <input type="number" step="0.01" name="price" id="price" min="0" value="{{ old('price', $item->price) }}" class="form-control @error('price') is-invalid @enderror">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="stock" class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $item->stock ?? 0) }}" class="form-control @error('stock') is-invalid @enderror">
                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input type="hidden" name="is_best_seller" value="0">
                        <input class="form-check-input" type="checkbox" name="is_best_seller" id="is_best_seller" value="1" @checked(old('is_best_seller', $item->is_best_seller ?? false))>
                        <label class="form-check-label fw-bold" for="is_best_seller">★ Mark as Best Seller</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label for="details" class="form-label fw-bold">Details</label>
                <textarea name="details" id="details" rows="3" class="form-control @error('details') is-invalid @enderror">{{ old('details', $item->details) }}</textarea>
                @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Image {{ $isEdit ? '(leave empty to keep current)' : '' }}</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if ($isEdit && $item->image_path)
                    @php
                        $isUrl = str_starts_with($item->image_path, 'http');
                        $currentImg = $isUrl ? $item->image_path : asset($item->image_path);
                    @endphp
                    <img src="{{ $currentImg }}" alt="current" class="mt-2 rounded" style="max-height: 100px; image-rendering: pixelated;">
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-poke">{{ $isEdit ? 'Save changes' : 'Add to shop' }}</button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </form>
    </div>
@endsection
