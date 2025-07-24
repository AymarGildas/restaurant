@extends('admin.layouts.app')

@section('page-title', 'Edit Type')

@section('content')

<form action="{{ route('admin.types.update', $type->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Name Field --}}
    <div class="mb-3">
        <label for="name" class="form-label">Type Name</label>
        <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name', $type->name) }}" 
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
        >{{ old('description', $type->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection