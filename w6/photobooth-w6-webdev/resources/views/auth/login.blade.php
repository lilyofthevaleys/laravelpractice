@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <main class="flex-grow-1 py-5" style="background: linear-gradient(180deg, #ee1515 0%, #ee1515 40%, #fafafa 40%, #fafafa 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="poke-card shadow-lg p-4 p-md-5">
                        <div class="text-center mb-4">
                            <span class="pokeball d-inline-block mb-3" style="width:64px;height:64px;"></span>
                            <h2 class="fw-bold section-title mb-1">Trainer Login</h2>
                            <p class="text-muted mb-0">Welcome back! Sign in to continue your journey.</p>
                        </div>

                        @if (! empty($fromCheckout))
                            <div class="alert text-center py-2 mb-3" style="background:#fff5f5;border:1px solid #ee1515;color:#a51818;">
                                Log in to complete your checkout — your cart is waiting.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input id="password" name="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input id="remember" name="remember" type="checkbox"
                                    class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-poke btn-lg w-100 mb-3">Sign In</button>

                            <p class="text-center text-muted mb-0">
                                New trainer? <a href="{{ route('register') }}" class="fw-bold">Create an account</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
