@extends('admin.layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>User Details</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-info">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <strong>Name:</strong> <span class="ms-2">{{ $user->name }}</span>
        </div>

        <div class="mb-3">
            <strong>Email:</strong> <span class="ms-2">{{ $user->email }}</span>
        </div>

        <div class="mb-3">
            <strong>Roles:</strong>
            <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach($user->getRoleNames() as $role)
                    <span class="badge bg-success">{{ $role }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
