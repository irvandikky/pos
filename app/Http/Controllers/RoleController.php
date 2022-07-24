<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list roles', Role::class);

        $roles = Role::latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render(
            'Roles/Index',
            [
                'roles' => $roles,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create roles', Role::class);

        $permissions = Permission::select('id', 'name')->get()->map(function ($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();

        return Inertia::render(
            'Roles/Create',
            [
                'permissions' => $permissions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create roles', Role::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:roles|max:32',
            'permissions' => 'array',
            'permissions' => 'required|array',
            'permissions.*.value' => ['required', Rule::in(Permission::select('id')->pluck('id')->toArray()) ]
        ]);

        $role = Role::create($data);
        $permissions = array_map(function ($value) {
            return $value['value'];
        }, $request->permissions);
        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.show', $role->id)
            ->withMessage(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view roles', Role::class);

        return Inertia::render(
            'Roles/View',
            [
                'roles' => $role,
                'permissions' => $role->permissions()->get(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('update roles', $role);

        $permissions = Permission::select('id', 'name')->get()->map(function ($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();

        $role['permissions'] = $role->permissions()->get()->map(function ($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();
        return Inertia::render(
            'Roles/Edit',
            [
                'permissions' => $permissions,
                'roles' => $role,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update roles', $role);

        $data = $this->validate($request, [
            'name' => 'required|max:32|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*.value' => ['required', Rule::in(Permission::select('id')->pluck('id')->toArray()) ]
        ]);

        $role->update($data);

        $permissions = array_map(function ($value) {
            return $value['value'];
        }, $request->permissions);

        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.edit', $role->id)
            ->withMessage(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete roles', $role);

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->withMessage(__('crud.common.removed'));
    }
}
