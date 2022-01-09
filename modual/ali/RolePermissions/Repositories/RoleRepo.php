<?php

namespace ali\RolePermissions\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepo
{

    public function all()
    {
        return Role::all();

    }

    public function create($request)
    {

        return Role::create(['name' => $request->name])->syncPermissions($request->permissions);

    }

    public function finById($id)
    {
        return Role::findOrFail($id);
    }

    public function update($id, $request)
    {
        $role = $this->finById($id);

        return $role->syncPermissions($request->permissions)->update(['name' => $request->name]);
    }

    public function delete($id)
    {

        Role::query()->where('id', $id)->delete();
    }

}
