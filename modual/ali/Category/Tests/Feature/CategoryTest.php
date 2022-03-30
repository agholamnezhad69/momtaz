<?php


namespace ali\Category\Tests\Feature;

use ali\Category\Models\Category;
use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CategoryTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;


    public function test_permitted_user_can_see_categories_panel()
    {
        $this->actionAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        $this->get(route('categories.index'))->assertOk();

    }

    public function test_normal_user_can_not_see_categories_panel()
    {
        $this->actionAsUser();
        $this->get(route('categories.index'))
            ->assertStatus(403);

    }

    public function test_permitted_user_can_creat_category()
    {

        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
    }

    public function test_permitted_user_can_update_category()
    {
        $newTitle = "ali";
        $this->actionAsAdmin();
        $this->createCategory();
        $this->patch(route('categories.update', 1),
            ['title' => $newTitle, 'slug' => $this->faker->word]);
        $this->assertEquals(1, Category::whereTitle($newTitle)->count());
    }

    public function test_permitted_user_can_delete_category()
    {

        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());


        $this->delete(route('categories.destroy', 1))->assertOk();


    }

    private function actionAsAdmin()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }


    private function createCategory()
    {
        $this->post(route('categories.store'),
            [
                'title' => $this->faker->word,
                'slug' => $this->faker->word
            ]);
    }

    private function actionAsUser()
    {

        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);

    }
}
