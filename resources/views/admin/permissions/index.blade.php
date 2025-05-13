@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permission Management</h1>
        @can('create permissions')
        <a href="{{ route('admin.permissions.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Permission
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
            <form action="{{ route('admin.permissions.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Search by permission name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="per_page">Items Per Page</label>
                        <select class="form-control" id="per_page" name="per_page">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_by">Group By Module</label>
                        <select class="form-control" id="group_by" name="group_by">
                            <option value="1" {{ $groupBy ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$groupBy ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <!-- Permissions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
        </div>
        <div class="card-body">
            @if($groupBy)
                <!-- Grouped Permissions -->
                <div class="accordion" id="permissionsAccordion">
                    @forelse($permissions as $module => $modulePermissions)
                        <div class="card">
                            <div class="card-header p-0" id="heading{{ $module }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $module }}" aria-expanded="true" aria-controls="collapse{{ $module }}">
                                        {{ ucfirst($module) }} Permissions ({{ count($modulePermissions) }})
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $module }}" class="collapse" aria-labelledby="heading{{ $module }}" data-parent="#permissionsAccordion">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Roles</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($modulePermissions as $permission)
                                                    <tr>
                                                        <td>{{ $permission->id }}</td>
                                                        <td>{{ $permission->name }}</td>
                                                        <td>
                                                            <span class="badge badge-secondary">{{ $permission->roles->count() }} roles</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                @can('view permissions')
                                                                <a href="{{ route('admin.permissions.show', $permission->id) }}" class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                @endcan
                                                                
                                                                @can('edit permissions')
                                                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                @endcan
                                                                
                                                                @can('delete permissions')
                                                                @if($permission->roles->count() === 0)
                                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                @endif
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No permissions found.</p>
                    @endforelse
                </div>
            @else
                <!-- Paginated Permissions -->
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $permission->roles->count() }} roles</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view permissions')
                                            <a href="{{ route('admin.permissions.show', $permission->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('edit permissions')
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete permissions')
                                            @if($permission->roles->count() === 0)
                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">
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
                                    <td colspan="4" class="text-center">No permissions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $permissions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
