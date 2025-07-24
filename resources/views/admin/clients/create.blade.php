@extends('admin.layouts.app')

@section('page-title', 'Create Client')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create New Client</h5>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary btn-sm">
                 &larr; Back to Clients
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Adresse --}}
                    <div class="col-12 mb-3">
                        <label for="adresse" class="form-label fw-bold">Address</label>
                        <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contact --}}
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label fw-bold">Contact</label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact') }}" required>
                        @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Secteur --}}
                    <div class="col-md-6 mb-3">
                        <label for="secteur" class="form-label fw-bold">Secteur</label>
                        <input type="text" class="form-control @error('secteur') is-invalid @enderror" id="secteur" name="secteur" value="{{ old('secteur') }}" required>
                        @error('secteur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Create Client</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
