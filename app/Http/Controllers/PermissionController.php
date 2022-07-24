<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list permissions', Permission::class);

        $permissions = Permission::latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render(
            'Permissions/Index',
            [
                'permissions' => $permissions,
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
        $this->authorize('create permissions', Permission::class);
        return Inertia::render('Permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create permissions', Permission::class);

        $data = $this->validate($request, [
            'name' => 'required|max:64',
        ]);

        $permission = Permission::create($data);

        return redirect()
            ->route('permissions.show', $permission->id)
            ->withMessage(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->authorize('view permissions', Permission::class);

        return Inertia::render(
            'Permissions/View',
            [
                'permissions' => $permission,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update permissions', $permission);

        return Inertia::render(
            'Permissions/Edit',
            [
                'permissions' => $permission,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update permissions', $permission);

        $data = $this->validate($request, [
            'name' => 'required|max:40',
        ]);

        $permission->update($data);

        return redirect()
            ->route('permissions.edit', $permission->id)
            ->withMessage(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete permissions', $permission);

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->withMessage(__('crud.common.removed'));
    }
}
