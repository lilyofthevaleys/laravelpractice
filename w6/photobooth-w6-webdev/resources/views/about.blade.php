@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('img/about.jpg') }}" alt="Our Team" class="img-fluid rounded shadow-lg img-thumbnail">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3 text-dark">About Us</h1>
                    <p class="lead text-muted mb-4">We are more than just a photobooth company. We are creators of joy and capturers of memories across Indonesia.</p>
                    <p class="text-secondary">
                        Founded in 2020 in the vibrant city of Surabaya, Snap & Joy Photobooth started with a simple idea: making professional photography fun and accessible at any local event. Over the years, we have served hundreds of weddings, corporate events in Jawa Timur, and private parties, ensuring every guest leaves with a smile and a bespoke physical memory.
                    </p>
                    <div class="accordion mt-4 shadow-sm" id="aboutAccordion">
                        <div class="accordion-item border-0 border-bottom border-warning">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Our Mission
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-secondary">
                                    To provide top-tier, entertaining, and memorable photobooth experiences tailored to each client's unique vision in Indonesia.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 pb-1 border-bottom border-warning">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Our Vision
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-secondary">
                                    To be the leading innovator in event entertainment and interactive photography worldwide.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
