@extends('admin.layouts.app')

@section('page-title', 'Menus')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Menus</h2>
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">Add New Menu</a>
</div>

@if ($menus->count())
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
        @foreach ($menus as $menu)
            <tr>
                <td>{{ $loop->iteration + ($menus->currentPage() - 1) * $menus->perPage() }}</td>
                <td>{{ $menu->name }}</td>
                <td>{{ Str::limit($menu->description, 50) }}</td> {{-- Limits description to 50 chars --}}
                <td>{{ $menu->user->name ?? 'N/A' }}</td> {{-- Shows the creator's name --}}
                <td>{{ $menu->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this menu?');">
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

{{ $menus->links() }}

@else
<p>No menus found.</p>
@endif
@endsection
