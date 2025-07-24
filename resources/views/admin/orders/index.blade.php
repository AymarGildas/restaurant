@extends('admin.layouts.app')

@section('page-title', 'Orders')

@section('content')

@if ($orders->count())
<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Total Amount</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer ? $order->customer->name : 'N/A' }}</td>
            <td>
                <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'secondary') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td>
                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this order?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $orders->links() }}

@else
<p>No orders found.</p>
@endif
@endsection
