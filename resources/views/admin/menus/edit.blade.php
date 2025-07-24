@extends('admin.layouts.app')

@section('page-title', 'Edit Menu')

@section('content')

<form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Name Field --}}
    <div class="mb-3">
        <label for="name" class="form-label">Menu Name</label>
        <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name', $menu->name) }}" 
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
        >{{ old('description', $menu->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection