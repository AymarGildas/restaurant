@extends('admin.layouts.app')

@section('page-title', 'Create Role')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Create Role</h2>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <h5>Permissions</h5>

                <div class="form-check mb-2">
                    <input type="checkbox" id="select-all-permissions" class="form-check-input">
                    <label for="select-all-permissions" class="form-check-label">Select All</label>
                </div>

                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input permission-checkbox" 
                                    id="perm_{{ $permission->id }}" 
                                    name="permissions[]" 
                                    value="{{ $permission->name }}"
                                    {{ (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                <label for="perm_{{ $permission->id }}" class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Create Role</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-permissions');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    });
</script>
@endpush
@endsection
