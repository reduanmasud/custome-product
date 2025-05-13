@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Audit Logs</h1>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.audits.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Search in audit logs">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event_type">Event Type</label>
                        <select class="form-control" id="event_type" name="event_type">
                            <option value="">All Events</option>
                            @foreach($eventTypes as $event)
                                <option value="{{ $event }}" {{ $eventType == $event ? 'selected' : '' }}>
                                    {{ ucfirst($event) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="auditable_type">Model Type</label>
                        <select class="form-control" id="auditable_type" name="auditable_type">
                            <option value="">All Types</option>
                            @foreach($auditableTypes as $type)
                                <option value="{{ $type }}" {{ $auditableType == $type ? 'selected' : '' }}>
                                    {{ class_basename($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="user_id">User</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="date_from">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="per_page">Items Per Page</label>
                        <select class="form-control" id="per_page" name="per_page">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sort_by">Sort By</label>
                        <select class="form-control" id="sort_by" name="sort_by">
                            <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Date</option>
                            <option value="event" {{ $sortBy == 'event' ? 'selected' : '' }}>Event</option>
                            <option value="auditable_type" {{ $sortBy == 'auditable_type' ? 'selected' : '' }}>Type</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sort_direction">Sort Direction</label>
                        <select class="form-control" id="sort_direction" name="sort_direction">
                            <option value="desc" {{ $sortDirection == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ $sortDirection == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('admin.audits.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Audit Logs</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Model</th>
                            <th>Model ID</th>
                            <th>Changes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($audit->user)
                                        {{ $audit->user->name }}
                                    @else
                                        System
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $audit->event === 'created' ? 'success' : ($audit->event === 'updated' ? 'primary' : 'danger') }}">
                                        {{ ucfirst($audit->event) }}
                                    </span>
                                </td>
                                <td>{{ class_basename($audit->auditable_type) }}</td>
                                <td>{{ $audit->auditable_id }}</td>
                                <td>
                                    @if($audit->event === 'created')
                                        <span class="badge badge-success">New Record</span>
                                    @elseif($audit->event === 'updated')
                                        @php
                                            $changes = count(json_decode($audit->new_values, true));
                                        @endphp
                                        <span class="badge badge-primary">{{ $changes }} {{ Str::plural('change', $changes) }}</span>
                                    @elseif($audit->event === 'deleted')
                                        <span class="badge badge-danger">Record Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.audits.show', $audit->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No audit logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $audits->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
