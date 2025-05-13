@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Details: {{ ucfirst($role->name) }}</h1>
        <div>
            @can('edit roles')
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Role
            </a>
            @endcan
            <a href="{{ route('admin.roles.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Roles
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Role Information -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $role->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ ucfirst($role->name) }}</td>
                        </tr>
                        <tr>
                            <th>Permissions Count:</th>
                            <td>{{ count($rolePermissions) }}</td>
                        </tr>
                        <tr>
                            <th>Users Count:</th>
                            <td>{{ $role->users->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Permissions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
        </div>
        <div class="card-body">
            @php
                $permissionsByGroup = [];
                
                foreach($rolePermissions as $permission) {
                    $parts = explode(' ', $permission);
                    $group = $parts[0];
                    
                    if(!isset($permissionsByGroup[$group])) {
                        $permissionsByGroup[$group] = [];
                    }
                    
                    $permissionsByGroup[$group][] = $permission;
                }
                
                ksort($permissionsByGroup);
            @endphp
            
            @if(count($permissionsByGroup) > 0)
                <div class="accordion" id="permissionsAccordion">
                    @foreach($permissionsByGroup as $group => $permissions)
                        <div class="card">
                            <div class="card-header p-0" id="heading{{ $group }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $group }}" aria-expanded="true" aria-controls="collapse{{ $group }}">
                                        {{ ucfirst($group) }} Permissions ({{ count($permissions) }})
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $group }}" class="collapse" aria-labelledby="heading{{ $group }}" data-parent="#permissionsAccordion">
                                <div class="card-body">
                                    @foreach($permissions as $permission)
                                        <span class="badge badge-info p-2 m-1">{{ $permission }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No permissions assigned to this role.</p>
            @endif
        </div>
    </div>

    <!-- Users with this Role -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users with this Role</h6>
        </div>
        <div class="card-body">
            @if($role->users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view users')
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('edit users')
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
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
                <p class="text-muted">No users have been assigned this role.</p>
            @endif
        </div>
    </div>
</div>
@endsection
