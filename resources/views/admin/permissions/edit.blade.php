@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Permission: {{ $permission->name }}</h1>
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
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name">Permission Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Format should be: <code>[module] [action]</code>, e.g., "user view", "product create"
                    </small>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Warning: Changing permission names may affect existing role assignments and application functionality.
                </div>
                
                <button type="submit" class="btn btn-primary">Update Permission</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    
    <!-- Roles with this Permission -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles with this Permission</h6>
        </div>
        <div class="card-body">
            @if($permission->roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permission->roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ ucfirst($role->name) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view roles')
                                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('edit roles')
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No roles have been assigned this permission.</p>
            @endif
        </div>
    </div>
</div>
@endsection
