@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="poke-card p-4 p-md-5">
                        <h1 class="fw-bold section-title mb-1"><i class="bi bi-person-fill me-2"></i>Profile</h1>
                        <p class="text-muted mb-4">Update your trainer details</p>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Role</label>
                                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('shop') }}" class="btn btn-poke-outline">Cancel</a>
                                <button type="submit" class="btn btn-poke">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
