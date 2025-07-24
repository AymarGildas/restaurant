@extends('admin.layouts.app')

@section('page-title', 'Role Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Role Details</h2>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <h5>Role Name:</h5>
            <p>{{ $role->name }}</p>
        </div>

        <div class="mb-3">
            <h5>Assigned Permissions:</h5>
            @if($role->permissions->count())
                <ul class="list-group">
                    @foreach ($role->permissions as $permission)
                        <li class="list-group-item">{{ $permission->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">This role has no assigned permissions.</p>
            @endif
        </div>
    </div>
</div>
@endsection
