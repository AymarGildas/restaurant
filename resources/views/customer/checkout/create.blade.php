@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h1 class="mb-4 fw-bold">Checkout</h1>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('customer.checkout.store') }}" method="POST">
                @csrf
                <div class="row g-5">
                    {{-- Order Summary --}}
                    <div class="col-md-5 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Your Cart</span>
                            <span class="badge bg-primary rounded-pill">{{ count($cart) }}</span>
                        </h4>
                        <ul class="list-group mb-3">
                            @foreach($cart as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Quantity: {{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-muted">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">Total (USD)</span>
                                <strong class="fw-bold">${{ number_format($total, 2) }}</strong>
                            </li>
                        </ul>
                    </div>

                    {{-- Delivery & Payment Details --}}
                    <div class="col-md-7">
                        <h4 class="mb-3">Delivery Details</h4>
                        <div class="card shadow-sm border-0 p-4">
                            
                            {{-- Delivery Type --}}
                            <div class="my-3">
                                <div class="form-check">
                                    <input id="delivery" name="delivery_type" type="radio" value="delivery" class="form-check-input" checked required>
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input id="pickup" name="delivery_type" type="radio" value="pickup" class="form-check-input" required>
                                    <label class="form-check-label" for="pickup">Pickup</label>
                                </div>
                            </div>
                            
                            {{-- Delivery Address Field --}}
                            <div class="mb-3" id="deliveryAddressField">
                                <label for="delivery_address" class="form-label">Delivery Address</label>
                                <input type="text" class="form-control @error('delivery_address') is-invalid @enderror" id="delivery_address" name="delivery_address" value="{{ old('delivery_address', auth()->user()->adresse) }}">
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Notes Field --}}
                            <div class="mb-3">
                                <label for="notes" class="form-label">Order Notes (optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                            </div>

                            <hr class="my-4">

                            <button class="w-100 btn btn-primary btn-lg" type="submit">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript to show/hide the address field based on delivery type
    document.addEventListener('DOMContentLoaded', function () {
        const deliveryRadio = document.getElementById('delivery');
        const pickupRadio = document.getElementById('pickup');
        const addressField = document.getElementById('deliveryAddressField');

        function toggleAddressField() {
            if (pickupRadio.checked) {
                addressField.style.display = 'none';
            } else {
                addressField.style.display = 'block';
            }
        }

        deliveryRadio.addEventListener('change', toggleAddressField);
        pickupRadio.addEventListener('change', toggleAddressField);

        // Initial check
        toggleAddressField();
    });
</script>
@endsection
