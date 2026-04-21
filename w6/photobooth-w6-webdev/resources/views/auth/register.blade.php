@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
    <main class="flex-grow-1 py-5" style="background: linear-gradient(180deg, #ee1515 0%, #ee1515 40%, #fafafa 40%, #fafafa 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="poke-card shadow-lg p-4 p-md-5">
                        <div class="text-center mb-4">
                            <span class="pokeball d-inline-block mb-3" style="width:64px;height:64px;"></span>
                            <h2 class="fw-bold section-title mb-1">Become a Trainer</h2>
                            <p class="text-muted mb-0">Create your Pokémart account to start your journey.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Trainer Name</label>
                                <input id="name" name="name" type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input id="password" name="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    required>
                                <div class="form-text">At least 8 characters.</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control form-control-lg" required>
                            </div>

                            <button type="submit" class="btn btn-poke btn-lg w-100 mb-3">Create Account</button>

                            <p class="text-center text-muted mb-0">
                                Already a trainer? <a href="{{ route('login') }}" class="fw-bold">Sign in</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
