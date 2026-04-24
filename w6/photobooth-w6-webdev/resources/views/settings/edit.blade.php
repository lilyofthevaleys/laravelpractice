@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="poke-card p-4 p-md-5">
                        <h1 class="fw-bold section-title mb-1"><i class="bi bi-gear-fill me-2"></i>Settings</h1>
                        <p class="text-muted mb-4">Change your password</p>

                        <form method="POST" action="{{ route('settings.password') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-bold">Current password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">New password</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm new password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('shop') }}" class="btn btn-poke-outline">Cancel</a>
                                <button type="submit" class="btn btn-poke">Update password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
