@extends('layouts.app')

@section('title', $pokemon->exists ? 'Edit Pokemon' : 'Add Pokemon')

@section('content')
    @php
        $isEdit = $pokemon->exists;
        $action = $isEdit ? route('pokemon.update', $pokemon) : route('pokemon.store');
        $heading = $isEdit ? "Edit {$pokemon->name}" : 'Catch a New Pokemon';
    @endphp

    <main class="flex-grow-1 py-5">
        <div class="container" style="max-width: 720px;">
            <div class="mb-4">
                <a href="{{ route('shop') }}" class="text-decoration-none">&larr; Back to shop</a>
            </div>

            <div class="card poke-card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-4 section-title">{{ $heading }}</h1>

                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $pokemon->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="">-- choose --</option>
                                    @foreach (['Fire','Water','Grass','Electric','Fairy','Normal','Ghost','Psychic','Dragon','Rock','Ground','Ice','Bug','Flying','Fighting','Poison','Steel','Dark'] as $t)
                                        <option value="{{ $t }}" @selected(old('type', $pokemon->type) === $t)>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="hp" class="form-label">HP</label>
                                <input type="number" name="hp" id="hp" min="1" max="999" value="{{ old('hp', $pokemon->hp) }}" class="form-control @error('hp') is-invalid @enderror">
                                @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label">Price (Rp)</label>
                                <input type="number" step="0.01" name="price" id="price" min="0" value="{{ old('price', $pokemon->price) }}" class="form-control @error('price') is-invalid @enderror">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $pokemon->stock ?? 0) }}" class="form-control @error('stock') is-invalid @enderror">
                                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea name="details" id="details" rows="3" class="form-control @error('details') is-invalid @enderror">{{ old('details', $pokemon->details) }}</textarea>
                            @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Image {{ $isEdit ? '(leave empty to keep current)' : '' }}</label>
                            <input type="file" name="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if ($isEdit && $pokemon->image_path)
                                <img src="{{ asset($pokemon->image_path) }}" alt="current" class="mt-2 rounded" style="max-height: 100px;">
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-poke">{{ $isEdit ? 'Save changes' : 'Catch it' }}</button>
                            <a href="{{ route('shop') }}" class="btn btn-outline-dark">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
