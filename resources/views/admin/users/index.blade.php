@extends('admin.layouts.app')

@section('page-title', 'Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Users</h2>
    @can('user-create')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
    @endcan
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($users->count())
<table class="table table-striped table-bordered text-center">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $user)
        <tr>
            {{-- Just simple numbering since no pagination --}}
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @foreach($user->getRoleNames() as $role)
                    <span class="badge bg-success">{{ $role }}</span>
                @endforeach
            </td>
            <td>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>

                @php
                    $isSelf = auth()->id() === $user->id;
                    $currentUser = auth()->user();
                    $currentIsSuperAdmin = $currentUser->hasRole('Super Admin');
                    $currentIsAdmin = $currentUser->hasRole('Admin');
                    $targetIsAdmin = $user->hasRole('Admin') || $user->hasRole('Super Admin');
                @endphp

                @if($currentIsSuperAdmin || ($currentIsAdmin && (!$targetIsAdmin || $isSelf)))
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    @if(!$isSelf)
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    @endif
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Removed pagination links because you don't have paginator --}}

@else
<p>No users found.</p>
@endif

@endsection
