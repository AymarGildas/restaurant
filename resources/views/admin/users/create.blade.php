@extends('admin.layouts.app')

@section('page-title', 'Create User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Create User</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-info">Back</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
                @error('password_confirmation')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Roles</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($roles as $role)
                        @if(
                            !in_array($role->name, ['Super Admin', 'Admin']) 
                            || auth()->user()->hasRole('Super Admin')
                        )
                            <div class="form-check me-3">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    name="roles[]" 
                                    id="role_{{ $role->id }}" 
                                    value="{{ $role->name }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
