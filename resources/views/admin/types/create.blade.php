@extends('admin.layouts.app')

@section('page-title', 'Add New Type')

@section('content')

<form action="{{ route('admin.types.store') }}" method="POST">
    @csrf

    {{-- Name Field --}}
    <div class="mb-3">
        <label for="name" class="form-label">Type Name</label>
        <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name') }}" 
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Description Field --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea 
            class="form-control @error('description') is-invalid @enderror" 
            id="description" 
            name="description" 
            rows="4"
        >{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Create</button>
    <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
