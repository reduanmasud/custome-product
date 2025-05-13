@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Role: {{ ucfirst($role->name) }}</h1>
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
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required {{ $role->name === 'super-admin' ? 'readonly' : '' }}>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($role->name === 'super-admin')
                        <small class="text-muted">The super-admin role name cannot be changed.</small>
                    @endif
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
                                                    <input class="form-check-input module-checkbox" type="checkbox" id="select-all-{{ $module }}" data-module="{{ $module }}" {{ $role->name === 'super-admin' ? 'checked disabled' : '' }}>
                                                    <label class="form-check-label font-weight-bold" for="select-all-{{ $module }}">
                                                        Select All {{ ucfirst($module) }} Permissions
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            @foreach($modulePermissions as $permission)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox {{ $module }}-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" 
                                                            {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                                            {{ $role->name === 'super-admin' ? 'checked disabled' : '' }}>
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
                    
                    @if($role->name === 'super-admin')
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> The super-admin role always has all permissions.
                        </div>
                        
                        <!-- Hidden input to ensure all permissions are submitted for super-admin -->
                        @foreach($permissions as $modulePermissions)
                            @foreach($modulePermissions as $permission)
                                <input type="hidden" name="permissions[]" value="{{ $permission->name }}">
                            @endforeach
                        @endforeach
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Skip for super-admin role
        if ('{{ $role->name }}' === 'super-admin') {
            return;
        }
        
        // Handle "Select All" checkboxes
        document.querySelectorAll('.module-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const module = this.dataset.module;
                const isChecked = this.checked;
                
                document.querySelectorAll('.' + module + '-checkbox').forEach(function(permissionCheckbox) {
                    permissionCheckbox.checked = isChecked;
                });
            });
            
            // Set initial state
            const module = checkbox.dataset.module;
            const moduleCheckboxes = document.querySelectorAll('.' + module + '-checkbox');
            const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
            checkbox.checked = allChecked;
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
