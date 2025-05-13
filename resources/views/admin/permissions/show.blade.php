@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permission Details: {{ $permission->name }}</h1>
        <div>
            @can('edit permissions')
            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Permission
            </a>
            @endcan
            <a href="{{ route('admin.permissions.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Permissions
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Permission Information -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permission Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $permission->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $permission->name }}</td>
                        </tr>
                        <tr>
                            <th>Guard Name:</th>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $permission->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At:</th>
                            <td>{{ $permission->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Roles with this Permission -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles with this Permission</h6>
        </div>
        <div class="card-body">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Users Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ ucfirst($role->name) }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $role->users->count() }} users</span>
                                    </td>
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
