@extends('admin.layouts.app')

@section('page-title', 'Roles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Roles</h2>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Create New Role</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($roles->count())
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th width="50px">#</th>
            <th>Role Name</th>
            <th width="250px">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $index => $role)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" onsubmit="return confirm('Are you sure you want to delete this role?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <p>No roles found.</p>
@endif

@endsection
