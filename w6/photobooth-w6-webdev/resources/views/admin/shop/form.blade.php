@extends('layouts.admin')

@php
    $isEdit = $pokemon->exists;
    $action = $isEdit ? route('admin.shop.update', $pokemon) : route('admin.shop.store');
    $title = $isEdit ? 'Edit ' . $pokemon->name : 'Add Pokémon';
@endphp

@section('title', $title)
@section('heading', $title)
@section('subheading', $isEdit ? 'Update details for this Pokémon' : 'Catch a new Pokémon for the shop')

@section('content')
    <div class="mb-3"><a href="{{ route('admin.shop.index') }}" class="text-decoration-none">← Back to shop management</a></div>

    <div class="admin-card p-3 p-md-4" style="max-width: 780px;">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $pokemon->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="type" class="form-label fw-bold">Type</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">-- choose --</option>
                        @foreach (['Fire','Water','Grass','Electric','Fairy','Normal','Ghost','Psychic','Dragon','Rock','Ground','Ice','Bug','Flying','Fighting','Poison','Steel','Dark'] as $t)
                            <option value="{{ $t }}" @selected(old('type', $pokemon->type) === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="hp" class="form-label fw-bold">HP</label>
                    <input type="number" name="hp" id="hp" min="1" max="999" value="{{ old('hp', $pokemon->hp) }}" class="form-control @error('hp') is-invalid @enderror">
                    @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label fw-bold">Price (Rp)</label>
                    <input type="number" step="0.01" name="price" id="price" min="0" value="{{ old('price', $pokemon->price) }}" class="form-control @error('price') is-invalid @enderror">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="stock" class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $pokemon->stock ?? 0) }}" class="form-control @error('stock') is-invalid @enderror">
                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="hidden" name="is_best_seller" value="0">
                        <input class="form-check-input" type="checkbox" name="is_best_seller" id="is_best_seller" value="1" @checked(old('is_best_seller', $pokemon->is_best_seller ?? false))>
                        <label class="form-check-label fw-bold" for="is_best_seller">★ Mark as Best Seller</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label for="details" class="form-label fw-bold">Details</label>
                <textarea name="details" id="details" rows="3" class="form-control @error('details') is-invalid @enderror">{{ old('details', $pokemon->details) }}</textarea>
                @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Image {{ $isEdit ? '(leave empty to keep current)' : '' }}</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if ($isEdit && $pokemon->image_path)
                    @php
                        $isUrl = str_starts_with($pokemon->image_path, 'http');
                        $currentImg = $isUrl ? $pokemon->image_path : asset($pokemon->image_path);
                    @endphp
                    <img src="{{ $currentImg }}" alt="current" class="mt-2 rounded" style="max-height: 100px;">
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-poke">{{ $isEdit ? 'Save changes' : 'Catch it' }}</button>
                <a href="{{ route('admin.shop.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </form>
    </div>
@endsection
