<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if user has permission to view roles
        if (!auth()->user()->can('view roles')) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);

        $query = Role::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Get paginated roles
        $roles = $query->paginate($perPage);

        return view('admin.roles.index', [
            'roles' => $roles,
            'search' => $search,
            'perPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Check if user has permission to create roles
        if (!auth()->user()->can('create roles')) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all()->groupBy(function($permission) {
            return explode(' ', $permission->name)[0]; // Group by first word (module name)
        });

        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if user has permission to create roles
        if (!auth()->user()->can('create roles')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Check if user has permission to view roles
        if (!auth()->user()->can('view roles')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Check if user has permission to edit roles
        if (!auth()->user()->can('edit roles')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode(' ', $permission->name)[0]; // Group by first word (module name)
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Check if user has permission to edit roles
        if (!auth()->user()->can('edit roles')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $id],
            'permissions' => ['required', 'array'],
        ]);

        $role->name = $request->name;
        $role->save();
        
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Check if user has permission to delete roles
        if (!auth()->user()->can('delete roles')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::findOrFail($id);
        
        // Prevent deleting super-admin role
        if ($role->name === 'super-admin') {
            return back()->with('error', 'The super-admin role cannot be deleted.');
        }

        // Check if role is assigned to any users
        if ($role->users->count() > 0) {
            return back()->with('error', 'This role is assigned to users and cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
