@extends('admin.layouts.app')

@section('page-title', 'Show Order' . ' for ' . ($order->customer->name ?? 'N/A'))

@section('content')
<div class="container-fluid">
    {{-- Header with back and edit buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Order Details for {{ $order->customer->name ?? 'N/A' }}</h2>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                 &larr; Back to Orders
            </a>
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary">
                Edit This Order
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column: Customer & Order Items --}}
        <div class="col-lg-8">
            {{-- Customer Details Card --}}
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Customer Details</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                    @if($order->delivery_type == 'delivery')
                        <p class="mb-1"><strong>Delivery Address:</strong> {{ $order->delivery_address ?? 'Not provided' }}</p>
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
                                <td>{{ $item->plat->name ?? 'Item not found' }}</td>
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

        {{-- Right Column: Read-Only Order Info --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Order Placed</label>
                        <p class="form-control-plaintext ps-2">{{ $order->created_at->format('F j, Y, g:i A') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="ps-2"><span class="badge bg-primary rounded-pill fs-6">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Status</label>
                        <p class="ps-2"><span class="badge bg-success rounded-pill fs-6">{{ ucfirst($order->payment_status) }}</span></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Delivery Type</label>
                        <p class="form-control-plaintext ps-2">{{ ucfirst($order->delivery_type) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Customer Notes</label>
                        <p class="form-control-plaintext ps-2 fst-italic">{{ $order->notes ?? 'No notes provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
