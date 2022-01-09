<?php

namespace ali\RolePermissions\Http\Controllers;

use ali\Common\Responses\AjaxResponses;
use ali\RolePermissions\Http\Requests\RoleRequest;
use ali\RolePermissions\Http\Requests\RoleUpdateRequest;
use ali\RolePermissions\Models\Role;
use ali\RolePermissions\Repositories\PermissionRepo;
use ali\RolePermissions\Repositories\RoleRepo;
use App\Http\Controllers\Controller;


class RolePermissionsController extends Controller
{

    private $roleRepo;
    private $permissionRepo;

    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $this->authorize('index', Role::class);
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view("RolePermissions::index", compact('roles', 'permissions'));

    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $this->roleRepo->create($request);



        return redirect(route('role-permissions.index'));

    }

    public function edit($roleId)
    {

        $this->authorize('edit', Role::class);
        $role = $this->roleRepo->finById($roleId);
        $permissions = $this->permissionRepo->all();


        return view("RolePermissions::edit", compact('role', 'permissions'));


    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $this->authorize('edit', Role::class);
        $this->roleRepo->update($id, $request);

        return redirect(route('role-permissions.index'));


    }

    public function destroy($roleId)
    {
        $this->authorize('delete', Role::class);
        $this->roleRepo->delete($roleId);
        return AjaxResponses::successResponse();
    }
}
