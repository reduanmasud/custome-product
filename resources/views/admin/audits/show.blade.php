@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Audit Log Details</h1>
        <a href="{{ route('admin.audits.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Audit Logs
        </a>
    </div>

    <!-- Alert Messages -->
    @include('admin.partials.alerts')

    <!-- Audit Information -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Audit Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td>{{ $audit->id }}</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>User:</th>
                            <td>
                                @if($audit->user)
                                    {{ $audit->user->name }} (ID: {{ $audit->user->id }})
                                @else
                                    System
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Event:</th>
                            <td>
                                <span class="badge badge-{{ $audit->event === 'created' ? 'success' : ($audit->event === 'updated' ? 'primary' : 'danger') }}">
                                    {{ ucfirst($audit->event) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Model Type:</th>
                            <td>{{ class_basename($audit->auditable_type) }}</td>
                        </tr>
                        <tr>
                            <th>Model ID:</th>
                            <td>{{ $audit->auditable_id }}</td>
                        </tr>
                        <tr>
                            <th>URL:</th>
                            <td>{{ $audit->url }}</td>
                        </tr>
                        <tr>
                            <th>IP Address:</th>
                            <td>{{ $audit->ip_address }}</td>
                        </tr>
                        <tr>
                            <th>User Agent:</th>
                            <td>
                                <small>{{ $audit->user_agent }}</small>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($audit->event === 'updated')
                        <h5 class="font-weight-bold">Changes</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Old Value</th>
                                        <th>New Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $oldValues = json_decode($audit->old_values, true) ?? [];
                                        $newValues = json_decode($audit->new_values, true) ?? [];
                                        $allFields = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                                    @endphp
                                    
                                    @foreach($allFields as $field)
                                        <tr>
                                            <td>{{ $field }}</td>
                                            <td>
                                                @if(array_key_exists($field, $oldValues))
                                                    @if(is_array($oldValues[$field]))
                                                        <pre>{{ json_encode($oldValues[$field], JSON_PRETTY_PRINT) }}</pre>
                                                    @else
                                                        {{ $oldValues[$field] }}
                                                    @endif
                                                @else
                                                    <em>Not set</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if(array_key_exists($field, $newValues))
                                                    @if(is_array($newValues[$field]))
                                                        <pre>{{ json_encode($newValues[$field], JSON_PRETTY_PRINT) }}</pre>
                                                    @else
                                                        {{ $newValues[$field] }}
                                                    @endif
                                                @else
                                                    <em>Removed</em>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($audit->event === 'created')
                        <h5 class="font-weight-bold">New Record Values</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $newValues = json_decode($audit->new_values, true) ?? [];
                                    @endphp
                                    
                                    @foreach($newValues as $field => $value)
                                        <tr>
                                            <td>{{ $field }}</td>
                                            <td>
                                                @if(is_array($value))
                                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($audit->event === 'deleted')
                        <h5 class="font-weight-bold">Deleted Record Values</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $oldValues = json_decode($audit->old_values, true) ?? [];
                                    @endphp
                                    
                                    @foreach($oldValues as $field => $value)
                                        <tr>
                                            <td>{{ $field }}</td>
                                            <td>
                                                @if(is_array($value))
                                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
