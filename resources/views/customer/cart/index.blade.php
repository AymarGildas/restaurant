@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h1 class="mb-4 fw-bold">Your Shopping Cart</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($cart) && count($cart) > 0)
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-4">Plat</th>
                                    <th class="py-3">Price</th>
                                    <th class="py-3 text-center" style="width: 150px;">Quantity</th>
                                    <th class="py-3">Subtotal</th>
                                    <th class="py-3 pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cart as $id => $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/100x100/EFEFEF/AAAAAA?text=No+Image' }}" alt="{{ $item['name'] }}" width="60" class="rounded me-3">
                                            <span class="fw-bold">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td class="text-center">
                                        {{-- UPDATE FORM --}}
                                        <form action="{{ route('customer.cart.update', $id) }}" method="POST" class="d-flex justify-content-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm text-center" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td class="pe-4 text-end">
                                        {{-- REMOVE FORM --}}
                                        <form action="{{ route('customer.cart.destroy', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    {{-- This part is now handled by the outer if/else block --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-light p-4">
                        <div class="d-flex justify-content-end align-items-center">
                            <h5 class="mb-0 me-3">Total:</h5>
                            <h4 class="mb-0 fw-bold text-primary">${{ number_format($total, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('landing') }}" class="btn btn-outline-secondary">
                        &larr; Continue Shopping
                    </a>
                    {{-- UPDATED LINK TO CHECKOUT --}}
                    <a href="{{ route('customer.checkout.create') }}" class="btn btn-primary btn-lg">
                        Proceed to Checkout &rarr;
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="lead">Your cart is empty.</p>
                    <a href="{{ route('landing') }}" class="btn btn-primary mt-3">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
