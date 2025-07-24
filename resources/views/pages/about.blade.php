@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<style>
    .about-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/landing/about.jpg') no-repeat center center;
        background-size: cover;
        padding: 6rem 0;
        color: white;
    }
    .feature-icon {
        font-size: 3rem;
        color: {{ $settings->secondary_color ?? '#FF6B6B' }};
    }
</style>

<div class="about-hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">About {{ $settings->site_name ?? 'FoodExpress' }}</h1>
        <p class="lead col-lg-8 mx-auto">Learn more about our passion for great food and excellent service.</p>
    </div>
</div>

<div class="container py-5">
    {{-- Our Story Section --}}
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-3">Our Story</h2>
            <p class="text-muted">{{ $settings->footer_about_text ?? 'Your favorite meals, delivered fast and fresh right to your door. Quality ingredients, unforgettable taste.' }}</p>
            <p class="text-muted">We started with a simple idea: to make delicious, restaurant-quality food accessible to everyone, everywhere. Our journey began in a small kitchen, with a passion for cooking and a commitment to using only the freshest, locally-sourced ingredients.</p>
        </div>
        <div class="col-lg-6">
            <img src="/images/landing/food1.jpg" class="img-fluid rounded shadow-lg" alt="Our Kitchen">
        </div>
    </div>

    <hr class="my-5">

    {{-- Why Choose Us Section --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">Why Choose Us?</h2>
    </div>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="feature-icon mb-3"><i class="fas fa-leaf"></i></div>
            <h5 class="fw-bold">Fresh Ingredients</h5>
            <p class="text-muted">We source the best local ingredients to ensure every dish is fresh and flavorful.</p>
        </div>
        <div class="col-md-4">
            <div class="feature-icon mb-3"><i class="fas fa-shipping-fast"></i></div>
            <h5 class="fw-bold">Fast Delivery</h5>
            <p class="text-muted">Our dedicated team ensures your food arrives hot and on time, every time.</p>
        </div>
        <div class="col-md-4">
            <div class="feature-icon mb-3"><i class="fas fa-star"></i></div>
            <h5 class="fw-bold">Quality Guaranteed</h5>
            <p class="text-muted">We stand by the quality of our food and offer a satisfaction guarantee.</p>
        </div>
    </div>
</div>
@endsection
