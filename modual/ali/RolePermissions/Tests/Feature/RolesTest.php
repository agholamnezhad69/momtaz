<?php

namespace ali\RolePermissions\Tests\Feature;

use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\RolePermissions\Models\Role;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolesTest extends TestCase

{

    use WithFaker;
    use RefreshDatabase;


    private function actAsNormalUser()
    {
        $this->createUser();
    }

    private function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSION);
    }

    private function actAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSION);
    }


    private function createUser()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createRole()
    {
        return Role::create(['name' => "test"])
            ->syncPermissions(
                [
                    Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                    Permission::PERMISSION_TEACH,
                ]
            );

    }

    public function test_permitted_user_can_see_index()
    {
        $this->actAsAdmin();
        $this->get(route('role-permissions.index'))->assertOk();

    }

    public function test_normal_user_can_not_see_index()
    {
        $this->actAsNormalUser();
        $this->get(route('role-permissions.index'))->assertStatus(403);

    }

    public function test_permitted_user_can_store_roles()
    {
        $this->actAsAdmin();
        $this->post(route('role-permissions.store'),
            [
                "name" => "test",
                "permissions" =>
                    [
                        Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                        Permission::PERMISSION_TEACH,

                    ]
            ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals(count(Role::$roles) + 1, Role::count());


    }

    public function test_normal_user_can_not_store_roles()
    {
        $this->actAsNormalUser();
        $this->post(route('role-permissions.store'),
            [
                "name" => "test",
                "permissions" =>
                    [
                        Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                        Permission::PERMISSION_TEACH,

                    ]
            ])->assertStatus(403);

        $this->assertEquals(count(Role::$roles), Role::count());


    }

    public function test_permitted_user_can_see_edit()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertOk();

    }

    public function test_normal_user_can_not_see_edit()
    {
        $this->actAsNormalUser();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertStatus(403);

    }

    public function test_permitted_user_can_update_roles()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id),
            [

                "id" => $role->id,
                "name" => "test123",
                "permissions" =>
                    [
                        Permission::PERMISSION_TEACH,
                    ]
            ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals("test123", $role->fresh()->name);


    }

    public function test_permitted_user_can_not_update_roles()
    {
        $this->actAsNormalUser();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id),
            [

                "id" => $role->id,
                "name" => "test123",
                "permissions" =>
                    [
                        Permission::PERMISSION_TEACH,
                    ]
            ])->assertStatus(403);

        $this->assertEquals($role->name, $role->fresh()->name);


    }

    public function test_permitted_user_can_delete_roles()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertOk();
        $this->assertEquals(count(Role::$roles), Role::count());


    }

    public function test_permitted_user_can_not_delete_roles()
    {

        $this->actAsNormalUser();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertStatus(403);
        $this->assertEquals(count(Role::$roles) + 1, Role::count());


    }


}
