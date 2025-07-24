@extends('admin.layouts.app')

@section('page-title', 'Plats')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Plats</h2>
    <a href="{{ route('admin.plats.create') }}" class="btn btn-primary">Add New Plat</a>
</div>

@if ($plats->count())
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Menu</th>
                <th>Type</th>
                <th>Price</th>
                <th>Active</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($plats as $plat)
            <tr>
                <td>{{ $loop->iteration + ($plats->currentPage() - 1) * $plats->perPage() }}</td>
                <td>
                    @if($plat->image)
                        <img src="{{ asset('storage/' . $plat->image) }}" alt="{{ $plat->name }}" width="60" height="60" style="object-fit: cover;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $plat->name }}</td>
                <td>{{ Str::limit($plat->description, 30) }}</td>
                <td>{{ $plat->menu->name ?? 'N/A' }}</td>
                <td>{{ $plat->type->name ?? 'N/A' }}</td>
                <td>${{ number_format($plat->price, 2) }}</td>
                <td>
                    @if ($plat->is_active)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-danger">No</span>
                    @endif
                </td>
                <td>{{ $plat->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.plats.edit', $plat->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.plats.destroy', $plat->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this plat?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $plats->links() }}

@else
<p>No plats found.</p>
@endif
@endsection
