@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details: {{ $user->name }}</h1>
        <div>
            @can('edit users')
            <a href="{{ route('admin.users.edit', $user->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit User
            </a>
            @endcan
            <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Users
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- User Information -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At:</th>
                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Roles</h5>
                    <div class="mb-3">
                        @forelse($user->roles as $role)
                            <span class="badge badge-primary p-2 mb-1">{{ ucfirst($role->name) }}</span>
                        @empty
                            <p class="text-muted">No roles assigned.</p>
                        @endforelse
                    </div>
                    
                    <h5 class="font-weight-bold">Permissions</h5>
                    <div>
                        @php
                            $allPermissions = $user->getAllPermissions()->pluck('name')->toArray();
                            $permissionsByGroup = [];
                            
                            foreach($allPermissions as $permission) {
                                $parts = explode(' ', $permission);
                                $group = $parts[0];
                                
                                if(!isset($permissionsByGroup[$group])) {
                                    $permissionsByGroup[$group] = [];
                                }
                                
                                $permissionsByGroup[$group][] = $permission;
                            }
                        @endphp
                        
                        @if(count($permissionsByGroup) > 0)
                            <div class="accordion" id="permissionsAccordion">
                                @foreach($permissionsByGroup as $group => $permissions)
                                    <div class="card">
                                        <div class="card-header p-0" id="heading{{ $group }}">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $group }}" aria-expanded="true" aria-controls="collapse{{ $group }}">
                                                    {{ ucfirst($group) }} ({{ count($permissions) }})
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
                            <p class="text-muted">No permissions assigned.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
