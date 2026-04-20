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
                            <form action="#" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="nameInput" name="name" placeholder="Ash Ketchum" required>
                                            <label for="nameInput">Trainer Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="emailInput" name="email" placeholder="ash@pallet.town" required>
                                            <label for="emailInput">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="packageSelect" name="package">
                                                <option selected disabled>What are you interested in?</option>
                                                <option>Buying a specific Pokémon</option>
                                                <option>Rookie Trainer plan</option>
                                                <option>Gym Challenger plan</option>
                                                <option>Elite Four Prep plan</option>
                                                <option>Custom / legendary request</option>
                                                <option>Something else</option>
                                            </select>
                                            <label for="packageSelect">Topic</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-4">
                                            <textarea class="form-control" placeholder="Tell us what you're looking for" id="messageInput" name="message" style="height: 150px" required></textarea>
                                            <label for="messageInput">Your Message</label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
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
