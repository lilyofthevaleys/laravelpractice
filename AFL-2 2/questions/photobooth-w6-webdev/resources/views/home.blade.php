@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main class="flex-grow-1">
        <!-- Hero Section with Carousel for simple built-in animation -->
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active text-white text-center py-5" style="height: 60vh; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/hero1.jpg') }}') center/cover;">
                    <div class="container h-100 d-flex flex-column justify-content-center align-items-center">
                        <h1 class="display-3 fw-bold mb-4">Capture Your Best Moments in Surabaya</h1>
                        <p class="lead mb-4">Premium photobooth experiences for your events, weddings, and parties across Jawa Timur!</p>
                        <a href="{{ route('services') }}" class="btn btn-warning btn-lg rounded-pill shadow text-dark fw-bold">View Packages</a>
                    </div>
                </div>
                <div class="carousel-item text-white text-center py-5" style="height: 60vh; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/hero2.jpg') }}') center/cover;">
                    <div class="container h-100 d-flex flex-column justify-content-center align-items-center">
                        <h1 class="display-3 fw-bold mb-4">Unlimited Fun & Instant Prints</h1>
                        <p class="lead mb-4">Bring joy to your guests with our interactive kiosks!</p>
                        <a href="{{ route('contact') }}" class="btn btn-warning btn-lg rounded-pill shadow text-dark fw-bold">Book Now</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        
        <div class="container my-5 py-5 text-center">
            <h2 class="mb-4 fw-bold text-dark">Why Choose Us?</h2>
            <div class="row g-4 mt-2">
                @foreach ($whyChooseUs as $item)
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm bg-white h-100 border-top border-warning border-3">
                            <h4 class="text-dark fw-bold mb-3">{{ $item['title'] }}</h4>
                            <p class="text-muted">{{ $item['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
