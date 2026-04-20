@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png" alt="Pikachu" class="img-fluid" style="max-height: 420px;">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3 section-title brand-font">About Pokémart</h1>
                    <p class="lead text-dark mb-4">More than a shop — we're the first stop on every trainer's journey.</p>
                    <p class="text-secondary">
                        Founded in Pallet Town by a team of former gym leaders and retired trainers, Pokémart has grown from a single counter next to Professor Oak's lab into a region-wide chain. We believe that every trainer deserves a healthy, well-raised partner — and that every Pokémon deserves a caring home.
                    </p>
                    <p class="text-secondary">
                        Our staff includes certified Nurse Joys, Breeder-qualified handlers, and type specialists for every element. Whether you're after your first starter or hunting for a legendary, we've got you covered.
                    </p>

                    <div class="accordion mt-4 shadow-sm" id="aboutAccordion">
                        <div class="accordion-item border-0" style="border-bottom: 2px solid #ee1515 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" style="color:#ee1515;">
                                    Our Mission
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-secondary">
                                    To connect every aspiring trainer with a Pokémon partner that matches their style, budget, and dreams — safely, ethically, and with full post-catch support.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0" style="border-bottom: 2px solid #ee1515 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" style="color:#ee1515;">
                                    Our Vision
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-secondary">
                                    A world where every Pokémon is loved, every trainer is prepared, and no starter ever goes un-adopted.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0" style="border-bottom: 2px solid #ee1515 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" style="color:#ee1515;">
                                    Our Guarantee
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-secondary">
                                    Every Pokémon comes with a 30-day health guarantee, documentation of moveset at time of sale, and free evolution consulting for the first stage.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Regions we source from -->
            <div class="py-5 mt-3">
                <h3 class="text-center fw-bold section-title mb-2">Regions We Source From</h3>
                <p class="text-center text-muted mb-5">Eight regions, one Pokémart — each home to a legendary icon</p>
                @php
                    $artwork = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/';
                    $regions = [
                        ['name' => 'Kanto',  'gen' => 'Gen I',    'icon' => 'Mewtwo',   'dex' => 150],
                        ['name' => 'Johto',  'gen' => 'Gen II',   'icon' => 'Ho-Oh',    'dex' => 250],
                        ['name' => 'Hoenn',  'gen' => 'Gen III',  'icon' => 'Rayquaza', 'dex' => 384],
                        ['name' => 'Sinnoh', 'gen' => 'Gen IV',   'icon' => 'Dialga',   'dex' => 483],
                        ['name' => 'Unova',  'gen' => 'Gen V',    'icon' => 'Reshiram', 'dex' => 643],
                        ['name' => 'Kalos',  'gen' => 'Gen VI',   'icon' => 'Xerneas',  'dex' => 716],
                        ['name' => 'Alola',  'gen' => 'Gen VII',  'icon' => 'Solgaleo', 'dex' => 791],
                        ['name' => 'Galar',  'gen' => 'Gen VIII', 'icon' => 'Zacian',   'dex' => 888],
                    ];
                @endphp
                <div class="row g-4">
                    @foreach ($regions as $region)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="poke-card h-100 text-center p-3 d-flex flex-column align-items-center region-card">
                                <div class="d-flex align-items-center justify-content-center mb-2" style="width:100px;height:100px;background:radial-gradient(circle,#fff5f5 0%,#fff 70%);border-radius:50%;">
                                    <img src="{{ $artwork }}{{ $region['dex'] }}.png" alt="{{ $region['icon'] }}" style="max-width:90px;max-height:90px;object-fit:contain;">
                                </div>
                                <h5 class="fw-bold mb-0 mt-2 section-title">{{ $region['name'] }}</h5>
                                <small class="text-muted">{{ $region['gen'] }}</small>
                                <small class="mt-1 fw-semibold" style="color:#1a1a1a;">Home of {{ $region['icon'] }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <style>
                    .region-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
                    .region-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(238,21,21,0.15); }
                </style>
            </div>
        </div>
    </main>
@endsection
