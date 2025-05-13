@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Role</h1>
        <a href="{{ route('admin.roles.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Roles
        </a>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Role Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label>Permissions <span class="text-danger">*</span></label>
                    @error('permissions')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="accordion" id="permissionsAccordion">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="card">
                                <div class="card-header p-0" id="heading{{ $module }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $module }}" aria-expanded="true" aria-controls="collapse{{ $module }}">
                                            {{ ucfirst($module) }} Permissions
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{{ $module }}" class="collapse" aria-labelledby="heading{{ $module }}" data-parent="#permissionsAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input module-checkbox" type="checkbox" id="select-all-{{ $module }}" data-module="{{ $module }}">
                                                    <label class="form-check-label font-weight-bold" for="select-all-{{ $module }}">
                                                        Select All {{ ucfirst($module) }} Permissions
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            @foreach($modulePermissions as $permission)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox {{ $module }}-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                            {{ str_replace($module . ' ', '', $permission->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Create Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle "Select All" checkboxes
        document.querySelectorAll('.module-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const module = this.dataset.module;
                const isChecked = this.checked;
                
                document.querySelectorAll('.' + module + '-checkbox').forEach(function(permissionCheckbox) {
                    permissionCheckbox.checked = isChecked;
                });
            });
        });
        
        // Update "Select All" checkbox state based on individual permissions
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const moduleClasses = Array.from(this.classList).filter(cls => cls.endsWith('-checkbox') && cls !== 'permission-checkbox');
                
                if (moduleClasses.length > 0) {
                    const moduleClass = moduleClasses[0];
                    const module = moduleClass.replace('-checkbox', '');
                    const selectAllCheckbox = document.querySelector('#select-all-' + module);
                    const moduleCheckboxes = document.querySelectorAll('.' + moduleClass);
                    const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
                    
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allChecked;
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
