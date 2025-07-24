@extends('admin.layouts.app')

@section('page-title', 'Add New Plat')

@section('content')

<form action="{{ route('admin.plats.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Plat Name</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            class="form-control @error('name') is-invalid @enderror" 
            value="{{ old('name') }}" 
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description (optional)</label>
        <textarea 
            id="description" 
            name="description" 
            class="form-control @error('description') is-invalid @enderror"
            rows="3"
        >{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Price --}}
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input 
            type="number" 
            id="price" 
            name="price" 
            class="form-control @error('price') is-invalid @enderror" 
            step="0.01" 
            min="0" 
            value="{{ old('price') }}" 
            required
        >
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Menu Dropdown --}}
    <div class="mb-3">
        <label for="menu_id" class="form-label">Menu</label>
        <select 
            id="menu_id" 
            name="menu_id" 
            class="form-select @error('menu_id') is-invalid @enderror" 
            required
        >
            <option value="">Select menu</option>
            @foreach ($menus as $menu)
                <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                    {{ $menu->name }}
                </option>
            @endforeach
        </select>
        @error('menu_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Type Dropdown --}}
    <div class="mb-3">
        <label for="type_id" class="form-label">Type</label>
        <select 
            id="type_id" 
            name="type_id" 
            class="form-select @error('type_id') is-invalid @enderror" 
            required
        >
            <option value="">Select type</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @error('type_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Image Upload --}}
    <div class="mb-3">
        <label for="image" class="form-label">Plat Image (optional)</label>
        <input 
            type="file" 
            id="image" 
            name="image" 
            class="form-control @error('image') is-invalid @enderror" 
            accept="image/*"
        >
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Is Active Checkbox --}}
    <div class="form-check mb-3">
        <input 
            type="checkbox" 
            id="is_active" 
            name="is_active" 
            class="form-check-input" 
            value="1" {{-- Set value to 1 for the checkbox --}}
            {{ old('is_active', true) ? 'checked' : '' }}
        >
        <label for="is_active" class="form-check-label">Active</label>
    </div>

    <button type="submit" class="btn btn-success">Create Plat</button>
    <a href="{{ route('admin.plats.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection