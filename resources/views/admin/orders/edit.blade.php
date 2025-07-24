@extends('admin.layouts.app')

@section('page-title', 'Edit Order #' . $order->id . ' for ' . ($order->customer->name ?? 'N/A'))

@section('content')
<div class="container-fluid">
    {{-- Header with back button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Order Details</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
             &larr; Back to Orders
        </a>
    </div>

    <div class="row g-4">
        {{-- Left Column: Customer & Order Details --}}
        <div class="col-lg-8">
            {{-- Customer Details Card --}}
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Customer Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                    @if($order->delivery_type == 'delivery')
                        <p><strong>Delivery Address:</strong> {{ $order->delivery_address ?? 'Not provided' }}</p>
                    @endif
                </div>
            </div>

            {{-- Order Items Card --}}
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Plat</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->plat->name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold fs-5">
                                <td colspan="3" class="text-end border-0">Total Amount:</td>
                                <td class="text-end border-0">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column: Update Form --}}
        <div class="col-lg-4">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="card shadow-sm border-0 rounded-3">
                @csrf
                @method('PUT')
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Update Order</h5>
                </div>
                <div class="card-body">
                    {{-- Order Info --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Order Placed</label>
                        <p class="form-control-plaintext ps-2">{{ $order->created_at->format('d M Y, H:i A') }}</p>
                    </div>
                    
                    {{-- Order Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            @foreach (['pending', 'accepted', 'preparing', 'on_the_way', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            @foreach (['pending', 'paid'] as $payment)
                                <option value="{{ $payment }}" {{ old('payment_status', $order->payment_status) == $payment ? 'selected' : '' }}>
                                    {{ ucfirst($payment) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Delivery Type (Read-Only) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Delivery Type</label>
                        <p class="form-control-plaintext ps-2">{{ ucfirst($order->delivery_type) }}</p>
                    </div>

                    {{-- Customer Notes (Read-Only) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Customer Notes</label>
                        <p class="form-control-plaintext ps-2 fst-italic">{{ $order->notes ?? 'No notes provided.' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
