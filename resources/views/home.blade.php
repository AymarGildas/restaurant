@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h1 class="mb-4 fw-bold">My Order History</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    @forelse($orders as $order)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <h5 class="mb-1">Order #{{ $order->id }}</h5>
                                <p class="mb-1 text-muted">Placed on: {{ $order->created_at->format('F j, Y') }}</p>
                                <p class="mb-0 fw-bold">Total: ${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary rounded-pill mb-2">{{ ucfirst($order->status) }}</span>
                                <br>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                    View Details
                                </button>
                            </div>
                        </div>

                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Details for Order #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Items Ordered:</h6>
                                        <ul class="list-group list-group-flush">
                                            @foreach($order->orderItems as $item)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        {{ $item->quantity }} x {{ $item->plat->name ?? 'N/A' }}
                                                    </span>
                                                    <span>${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                        <div class="text-end">
                                            <strong>Total: ${{ number_format($order->total_amount, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p class="lead">You haven't placed any orders yet.</p>
                            <a href="{{ route('landing') }}" class="btn btn-primary mt-3">Start Shopping</a>
                        </div>
                    @endforelse
                </div>
                
                @if($orders->hasPages())
                    <div class="card-footer bg-light">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection