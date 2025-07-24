@extends('admin.layouts.app')

@section('page-title', 'Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Types</h2>
    <a href="{{ route('admin.types.create') }}" class="btn btn-primary">Add New Type</a>
</div>

@if ($types->count())
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($types as $type)
            <tr>
                <td>{{ $loop->iteration + ($types->currentPage() - 1) * $types->perPage() }}</td>
                <td>{{ $type->name }}</td>
                <td>{{ Str::limit($type->description, 50) }}</td> {{-- Limits description to 50 chars --}}
                <td>{{ $type->user->name ?? 'N/A' }}</td> {{-- Shows the creator's name --}}
                <td>{{ $type->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.types.edit', $type->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this type?');">
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

{{ $types->links() }}

@else
<p>No types found.</p>
@endif
@endsection
