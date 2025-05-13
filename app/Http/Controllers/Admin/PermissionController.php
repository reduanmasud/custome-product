<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if user has permission to view permissions
        if (!auth()->user()->can('view permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $groupBy = $request->input('group_by', true);

        $query = Permission::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Get permissions
        $permissions = $query->get();

        // Group permissions by module if requested
        if ($groupBy) {
            $permissions = $permissions->groupBy(function($permission) {
                return explode(' ', $permission->name)[0]; // Group by first word (module name)
            });
        } else {
            // Paginate if not grouping
            $permissions = $query->paginate($perPage);
        }

        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'search' => $search,
            'perPage' => $perPage,
            'groupBy' => $groupBy
        ]);
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Check if user has permission to create permissions
        if (!auth()->user()->can('create permissions')) {
            abort(403, 'Unauthorized action.');
        }

        // Get existing modules for suggestions
        $modules = Permission::all()->map(function($permission) {
            return explode(' ', $permission->name)[0]; // Get first word (module name)
        })->unique()->values()->toArray();

        return view('admin.permissions.create', ['modules' => $modules]);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if user has permission to create permissions
        if (!auth()->user()->can('create permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified permission.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Check if user has permission to view permissions
        if (!auth()->user()->can('view permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $permission = Permission::findOrFail($id);
        
        // Get roles that have this permission
        $roles = $permission->roles;

        return view('admin.permissions.show', [
            'permission' => $permission,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Check if user has permission to edit permissions
        if (!auth()->user()->can('edit permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Check if user has permission to edit permissions
        if (!auth()->user()->can('edit permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $id],
        ]);

        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Check if user has permission to delete permissions
        if (!auth()->user()->can('delete permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $permission = Permission::findOrFail($id);
        
        // Check if permission is assigned to any roles
        if ($permission->roles->count() > 0) {
            return back()->with('error', 'This permission is assigned to roles and cannot be deleted.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
