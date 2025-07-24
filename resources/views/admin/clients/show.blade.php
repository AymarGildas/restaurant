@extends('admin.layouts.app')

@section('page-title', 'Client Details: ' . $client->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Client Profile</h2>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">
             &larr; Back to Clients
        </a>
    </div>

    <div class="row g-4">
        {{-- Left Column: Client Profile Card --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 text-center h-100">
                <div class="card-body">
                    <img src="https://placehold.co/120x120/EFEFEF/AAAAAA?text={{ substr($client->name, 0, 1) }}" class="rounded-circle mb-3" alt="Client Avatar">
                    <h4 class="card-title">{{ $client->name }}</h4>
                    <p class="text-muted">{{ $client->email }}</p>
                    <span class="badge bg-success fs-6">Customer</span>
                    <hr>
                    <div class="text-start">
                        <p><strong>Contact:</strong> {{ $client->contact }}</p>
                        <p><strong>Secteur:</strong> {{ $client->secteur }}</p>
                        <p class="mb-0"><strong>Address:</strong> {{ $client->adresse }}</p>
                    </div>
                    <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-primary w-100 mt-4">Edit Client</a>
                </div>
            </div>
        </div>

        {{-- Right Column: Recent Orders --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    {{-- This section requires you to pass the client's orders from the controller --}}
                    @if(isset($orders) && $orders->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td><span class="badge bg-primary">{{ ucfirst($order->status) }}</span></td>
                                        <td class="text-end fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p>This client has not placed any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
