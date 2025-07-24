@extends('layouts.app') {{-- Or your main frontend layout --}}

@section('title', 'Menus')

@section('content')
<style>
    /* Simple MacDonald-inspired warm color scheme */
    body {
        background: #f9f7f6;
        font-family: 'Arial', sans-serif;
        color: #333;
    }
    h1, h2 {
        font-weight: 700;
        color: #d90429; /* MacDonald red */
    }
    .menu-section {
        margin-bottom: 3rem;
    }
    .menu-title {
        border-bottom: 3px solid #d90429;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .plats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.8rem;
    }
    .plat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgb(217 217 217 / 0.5);
        overflow: hidden;
        transition: transform 0.25s ease;
        display: flex;
        flex-direction: column;
    }
    .plat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgb(217 217 217 / 0.7);
    }
    .plat-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .plat-info {
        padding: 1rem 1.2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .plat-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.6rem;
        color: #222;
    }
    .plat-description {
        font-size: 0.9rem;
        color: #555;
        flex-grow: 1;
        margin-bottom: 1rem;
    }
    .plat-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #d90429;
    }
    .btn-add {
        background: #d90429;
        color: white;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .btn-add:hover {
        background: #9b0219;
    }
</style>

<div class="container py-5">
    <h1 class="mb-4 text-center">Our menus</h1>

    @forelse($menus as $menu)
        <section class="menu-section">
            <h2 class="menu-title">{{ $menu->name }}</h2>

            @if($menu->plats->count())
                <div class="plats-grid">
                    @foreach($menu->plats as $plat)
                        <div class="plat-card">
                            @if($plat->image)
                                <img src="{{ asset('storage/' . $plat->image) }}" alt="{{ $plat->name }}" class="plat-image">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No image" class="plat-image">
                            @endif

                            <div class="plat-info">
                                <div>
                                    <div class="plat-name">{{ $plat->name }}</div>
                                    <p class="plat-description">{{ Str::limit($plat->description, 80) }}</p>
                                </div>

                                <div class="plat-footer">
                                    <div class="price">${{ number_format($plat->price, 2) }}</div>
                                    <button class="btn-add" data-plat-id="{{ $plat->id }}">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No plats available in this menu yet.</p>
            @endif
        </section>
    @empty
        <p>No menus found.</p>
    @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-add');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const platId = this.getAttribute('data-plat-id');
            fetch('{{ route("customer.cart.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                alert(data.message); // You can replace this with a nicer toast notification
                // Optional: update cart count badge here
            })
            .catch(error => {
                alert('Failed to add plat to cart.');
                console.error(error);
            });
        });
    });
});
</script>
@endsection