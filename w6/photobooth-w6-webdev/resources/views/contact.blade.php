@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card poke-card shadow-lg">
                        <div class="card-header text-center py-4" style="background: #ee1515; color: #fff; border-bottom: 3px solid #1a1a1a;">
                            <h2 class="mb-0 fw-bold brand-font">Get In Touch</h2>
                            <p class="mb-0 text-white-50 mt-2">Questions? Custom orders? Need a specific Pokémon? Drop us a line.</p>
                        </div>
                        <div class="card-body p-4 p-md-5 bg-white">
                            <form action="{{ route('contact.submit') }}" method="POST" novalidate>
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name') }}" placeholder="Ash Ketchum" required>
                                            <label for="nameInput">Trainer Name</label>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-1">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" name="email" value="{{ old('email') }}" placeholder="ash@pallet.town" required>
                                            <label for="emailInput">Email Address</label>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <select class="form-select @error('package') is-invalid @enderror" id="packageSelect" name="package" required>
                                                <option value="" disabled {{ old('package') ? '' : 'selected' }}>What are you interested in?</option>
                                                @foreach ($topics as $topic)
                                                    <option value="{{ $topic }}" {{ old('package') === $topic ? 'selected' : '' }}>{{ $topic }}</option>
                                                @endforeach
                                            </select>
                                            <label for="packageSelect">Topic</label>
                                        </div>
                                        @error('package')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Tell us what you're looking for" id="messageInput" name="message" style="height: 150px" required>{{ old('message') }}</textarea>
                                            <label for="messageInput">Your Message</label>
                                        </div>
                                        @error('message')
                                            <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button type="submit" class="btn btn-poke btn-lg w-100 rounded-pill shadow-sm">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Email</h5>
                        <p class="text-muted mb-0">halo@pokemart.co.id</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Pokégear</h5>
                        <p class="text-muted mb-0">+62 812-POKE-MART</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Flagship Store</h5>
                        <p class="text-muted mb-0">Pallet Town Square, Kanto<br>(Next to Oak's Lab)</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
