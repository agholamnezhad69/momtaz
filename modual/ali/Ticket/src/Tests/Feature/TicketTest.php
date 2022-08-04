<?php

namespace ali\Ticket\Tests\Feature;


use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\Ticket\Models\Ticket;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;

    private function createUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function actAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_TICKETS);
    }

    private function actAsNormalUser()
    {
        $this->createUser();
    }

    public function test_user_can_see_tickets()
    {
        $this->actAsNormalUser();
        $this->get(route('tickets.index'))->assertOk();

    }

    public function test_user_dont_login_can_not_see_tickets()
    {

        $this->get(route('tickets.index'))->assertRedirect(route('login'));

    }

    public function test_user_can_see_create_tickets()
    {
        $this->actAsNormalUser();
        $this->get(route('tickets.create'))->assertOk();

    }

    public function test_user_dont_login_can_not_see_create_tickets()
    {

        $this->get(route('tickets.create'))->assertRedirect(route('login'));

    }

    public function test_user_can_store_ticket()
    {
        $this->actAsNormalUser();
        $this->post(route("tickets.store"),
            ["title" => $this->faker->word, "body" => $this->faker->text]
        );
        $this->assertEquals(1, Ticket::all()->count());

    }

    public function test_user_can_not_store_ticket()
    {
        $this->post(route("tickets.store"),
            ["title" => $this->faker->word, "body" => $this->faker->text]
        );
        $this->assertEquals(0, Ticket::all()->count());

    }

    public function test_permitted_user_can_delete_ticket()
    {

        $this->createTicket();

        $this->delete(route("tickets.destroy", 1))->assertOk();

        $this->assertEquals(0, Ticket::all()->count());

    }

    public function test_permitted_user_can_not_delete_ticket()
    {

        $this->createTicket();

        $this->actAsNormalUser();
        $this->delete(route("tickets.destroy", 1))->assertStatus(403);

        $this->assertEquals(1, Ticket::all()->count());

    }

    public function createTicket(){
        $this->actAsAdmin();
        $this->post(route("tickets.store"),
            ["title" => $this->faker->word, "body" => $this->faker->text]
        );
        $this->assertEquals(1, Ticket::all()->count());
    }


}
