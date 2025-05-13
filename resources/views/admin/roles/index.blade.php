@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Management</h1>
        @can('create roles')
        <a href="{{ route('admin.roles.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Role
        </a>
        @endcan
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Search by role name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="per_page">Items Per Page</label>
                        <select class="form-control" id="per_page" name="per_page">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $role->permissions->count() }} permissions</span>
                                </td>
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
                                        
                                        @can('delete roles')
                                        @if($role->name !== 'super-admin' && $role->users->count() === 0)
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $roles->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
