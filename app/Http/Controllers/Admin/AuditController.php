<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Models\Audit\Role;
use App\Models\Audit\Permission;
use App\Models\User;

class AuditController extends Controller
{
    /**
     * Display a listing of the audits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if user has permission to view audit logs
        if (!auth()->user()->can('view audit logs')) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $eventType = $request->input('event_type', '');
        $auditableType = $request->input('auditable_type', '');
        $userId = $request->input('user_id', '');
        $dateFrom = $request->input('date_from', '');
        $dateTo = $request->input('date_to', '');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query = Audit::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('event', 'like', "%{$search}%")
                  ->orWhere('auditable_type', 'like', "%{$search}%")
                  ->orWhere('old_values', 'like', "%{$search}%")
                  ->orWhere('new_values', 'like', "%{$search}%");
            });
        }

        // Apply event type filter
        if (!empty($eventType)) {
            $query->where('event', $eventType);
        }

        // Apply auditable type filter
        if (!empty($auditableType)) {
            $query->where('auditable_type', 'like', "%{$auditableType}%");
        }

        // Apply user filter
        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }

        // Apply date range filter
        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Get paginated audits
        $audits = $query->paginate($perPage);

        // Get users for filter dropdown
        $users = User::all();

        // Get event types for filter dropdown
        $eventTypes = Audit::distinct('event')->pluck('event');

        // Get auditable types for filter dropdown
        $auditableTypes = Audit::distinct('auditable_type')->pluck('auditable_type');

        return view('admin.audits.index', [
            'audits' => $audits,
            'users' => $users,
            'eventTypes' => $eventTypes,
            'auditableTypes' => $auditableTypes,
            'search' => $search,
            'perPage' => $perPage,
            'eventType' => $eventType,
            'auditableType' => $auditableType,
            'userId' => $userId,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection
        ]);
    }

    /**
     * Display the specified audit.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Check if user has permission to view audit logs
        if (!auth()->user()->can('view audit logs')) {
            abort(403, 'Unauthorized action.');
        }

        $audit = Audit::findOrFail($id);

        return view('admin.audits.show', [
            'audit' => $audit
        ]);
    }
}
