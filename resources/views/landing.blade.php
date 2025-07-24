@extends('layouts.app')

@section('content')
{{-- 
    I've removed the extra <html>, <head>, and <body> tags 
    as they are already handled by your main layouts.app.blade.php file.
--}}

<style>
    /* Custom Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdfdfd;
    }

    /* --- Hero Section --- */
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/landing/hero.jpg') no-repeat center center;
        background-size: cover;
        height: 60vh;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
    }
    .hero .btn-primary {
        background-color: #FF6B6B;
        border-color: #FF6B6B;
        padding: 12px 30px;
        font-weight: 600;
    }
    .hero .btn-primary:hover {
        background-color: #e05252;
        border-color: #e05252;
    }

    /* --- Section Styling --- */
    .section-bg-light {
        background-color: #f8f9fa;
    }
    .section-title {
        font-weight: 700;
        color: #333;
    }

    /* --- Dish Card Styling --- */
    .plat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden; /* Ensures image corners are rounded */
    }
    .plat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .plat-card .card-img-top {
        height: 220px;
        object-fit: cover;
    }
    .plat-card .card-title {
        font-weight: 600;
        color: #333;
    }
    .plat-card .card-text {
        color: #666;
        font-size: 0.9rem;
    }
    .plat-card .price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #FF6B6B;
    }

    /* --- Tabs & Filters --- */
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-link:hover {
        border-bottom-color: #FF6B6B;
        color: #FF6B6B;
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="text-center px-3">
        <h1 class="mb-3">Your Favorite Meals, Delivered.</h1>
        <p class="lead mb-4">Fast • Fresh • Unforgettable</p>
        <a href="#menu-section" class="btn btn-primary btn-lg">Explore Menu</a>
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login / Register</a>
        @endguest
    </div>
</section>

<!-- About Section -->
<section class="py-5 section-bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <img src="/images/landing/about.jpg" class="img-fluid rounded shadow-lg" alt="About Us" />
            </div>
            <div class="col-md-6">
                <h2 class="section-title mb-3">About FoodExpress</h2>
                <p class="text-muted">We believe that great food brings people together. That's why we're dedicated to delivering delicious, high-quality meals straight from our kitchen to your doorstep. Using only the freshest ingredients, we craft every dish with love and care.</p>
                <p class="text-muted">Choose from a wide range of dishes and enjoy the taste of home, without the hassle!</p>
            </div>
        </div>
    </div>
</section>

<!-- Menu / Plats Section -->
<section id="menu-section" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Explore Our Dishes</h2>
            <p class="lead text-muted">Find the perfect meal from our wide selection.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-3">
                        <h5 class="mb-0 fw-bold">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('landing') }}" method="GET">
                            <input type="hidden" name="type" value="{{ request('type') }}">
                            <div class="mb-3">
                                <label for="menuFilter" class="form-label fw-semibold">Filter by Menu</label>
                                <select name="menu" id="menuFilter" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Menus</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}" {{ request('menu') == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{ route('landing') }}" class="btn btn-sm btn-outline-secondary w-100">Reset Filters</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Type Navigation Tabs -->
                <ul class="nav nav-tabs nav-fill mb-4" id="typeTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ !request('type') ? 'active' : '' }}" href="{{ route('landing', ['menu' => request('menu')]) }}">All</a>
                    </li>
                    @foreach ($types as $type)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('type') == $type->id ? 'active' : '' }}" href="{{ route('landing', ['type' => $type->id, 'menu' => request('menu')]) }}">
                                {{ $type->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Plats Display -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @forelse ($plats as $plat)
                        <div class="col">
                            <div class="card plat-card h-100">
                                <img src="{{ $plat->image ? asset('storage/' . $plat->image) : 'https://placehold.co/600x400/EFEFEF/AAAAAA?text=No+Image' }}" class="card-img-top" alt="{{ $plat->name }}">
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $plat->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $plat->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                                        <p class="price mb-0">${{ number_format($plat->price, 2) }}</p>
                                        
                                        {{-- UPDATED ADD TO CART BUTTON --}}
                                        <form action="{{ route('customer.cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plat_id" value="{{ $plat->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary fw-bold">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-secondary text-center">
                                No dishes found matching your criteria.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $plats->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Dishes Section -->
<section class="py-5 section-bg-light">
    <div class="container text-center">
        <h2 class="section-title mb-4">Our Featured Dishes</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card plat-card">
                    <img src="/images/landing/food1.jpg" class="card-img-top" alt="Dish 1" />
                    <div class="card-body">
                        <h5 class="card-title">Delicious Rice Bowl</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card plat-card">
                    <img src="/images/landing/food2.jpg" class="card-img-top" alt="Dish 2" />
                    <div class="card-body">
                        <h5 class="card-title">Homemade Cake</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card plat-card">
                    <img src="/images/landing/food3.jpg" class="card-img-top" alt="Dish 3" />
                    <div class="card-body">
                        <h5 class="card-title">Grilled Chicken</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection