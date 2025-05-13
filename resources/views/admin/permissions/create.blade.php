@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Permission</h1>
        <a href="{{ route('admin.permissions.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Permissions
        </a>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Permission Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permission Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name">Permission Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g., view users, edit products">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Format should be: <code>[module] [action]</code>, e.g., "user view", "product create"
                    </small>
                </div>
                
                <div class="mb-4">
                    <h5>Suggested Formats:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">Existing Modules</h6>
                                </div>
                                <div class="card-body">
                                    <p>Choose from existing modules:</p>
                                    <div class="d-flex flex-wrap">
                                        @foreach($modules as $module)
                                            <button type="button" class="btn btn-outline-primary btn-sm m-1 module-btn" data-module="{{ $module }}">
                                                {{ $module }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">Common Actions</h6>
                                </div>
                                <div class="card-body">
                                    <p>Common permission actions:</p>
                                    <div class="d-flex flex-wrap">
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="view">view</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="create">create</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="edit">edit</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="delete">delete</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="publish">publish</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="assign">assign</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm m-1 action-btn" data-action="manage">manage</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Create Permission</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        let selectedModule = '';
        let selectedAction = '';
        
        // Handle module button clicks
        document.querySelectorAll('.module-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                selectedModule = this.dataset.module;
                updatePermissionName();
                
                // Update active state
                document.querySelectorAll('.module-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Handle action button clicks
        document.querySelectorAll('.action-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                selectedAction = this.dataset.action;
                updatePermissionName();
                
                // Update active state
                document.querySelectorAll('.action-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Update the permission name input
        function updatePermissionName() {
            if (selectedModule && selectedAction) {
                nameInput.value = `${selectedModule} ${selectedAction}s`;
            } else if (selectedModule) {
                nameInput.value = selectedModule + ' ';
            } else if (selectedAction) {
                nameInput.value = selectedAction + ' ';
            }
        }
    });
</script>
@endpush
@endsection
