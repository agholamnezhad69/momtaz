<?php

namespace ali\Course\Tests\Feature;

use ali\Category\Models\Category;
use ali\Course\Models\Course;
use ali\Course\Models\Season;
use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeasonTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    private function createUser()
    {
        $this->actingAs(factory(User::class)->create());
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
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    private function actAsNormalUser()
    {
        $this->createUser();
    }

    private function createCourse()
    {
        $category = $this->createCategory();
        $data =
            [
                'teacher_id' => auth()->id(),
                'category_id' => $category->id,
                'title' => $this->faker->sentence(2),
                'slug' => $this->faker->sentence(2),
                'priority' => 12,
                'price' => 222,
                'percent' => 10,
                'type' => Course::TYPE_FREE,
                'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,
                'statues' => Course::STATUS_COMPLETED
            ];

        return Course::create($data);


    }

    private function createCategory()
    {
        return Category::create(
            [
                'title' => $this->faker->word,
                'slug' => $this->faker->word
            ]
        );

    }

    public function test_permitted_user_can_see_course_detail_page()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('courses.details', $course->id))->assertOk();


        $this->actAsSuperAdmin();
        $this->get(route('courses.details', $course->id))->assertOk();


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();
        $this->get(route('courses.details', $course->id))->assertOk();


    }

    public function test_not_permitted_user_can_see_course_detail_page()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsNormalUser();
        $this->get(route('courses.details', $course->id))->assertStatus(403);

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.details', $course->id))->assertStatus(403);


    }

    public function test_permitted_user_can_create_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title 2"
        ]);

        $this->assertEquals(2, Season::count());

        $this->assertEquals(2, Season::find(2)->number);


    }

    public function test_not_permitted_user_can_create_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsNormalUser();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ])->assertStatus(403);


        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ])->assertStatus(403);


    }

    public function test_permitted_user_can_edit_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->get(route('seasons.edit', 1))->assertOk();

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();
        $this->get(route('seasons.edit', 1))->assertOk();


    }

    public function test_not_permitted_user_can_edit_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->actAsNormalUser();

        $this->get(route('seasons.edit', 1))->assertStatus(403);


    }

    public function test_permitted_user_can_update_season()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->patch(route('seasons.update', 1), [
            "title" => "update test season title",
            "number" => "2"
        ]);
        $this->assertEquals("update test season title", Season::find(1)->title);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();
        $this->patch(route('seasons.update', 1), [
            "title" => "update 2 test season title",
            "number" => "3"
        ]);
        $this->assertEquals("update 2 test season title", Season::find(1)->title);


    }

    public function test_not_permitted_user_can_update_season()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->actAsNormalUser();

        $this->patch(route('seasons.update', 1), [
            "title" => "update test season title",
            "number" => "2"
        ]);
        $this->assertEquals("test season title", Season::find(1)->title);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);

        $this->patch(route('seasons.update', 1), [
            "title" => "update 2 test season title",
            "number" => "3"
        ]);
        $this->assertEquals("test season title", Season::find(1)->title);


    }

    public function test_permitted_user_can_delete_season()
    {

        $this->withoutExceptionHandling();
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->delete(route('seasons.destroy', 1))->assertOk();

        $this->assertEquals(0, Season::count());


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test 2 season title",
            "number" => "2"
        ]);


        $this->delete(route('seasons.destroy', 2))->assertOk();


        $this->assertEquals(0, Season::count());


    }

    public function test_not_permitted_user_can_delete_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);
        $this->assertEquals(1, Season::count());
        $this->actAsNormalUser();
        $this->delete(route('seasons.destroy', 1))->assertStatus(403);
        $this->assertEquals(1, Season::count());
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->delete(route('seasons.destroy', 1))->assertStatus(403);
        $this->assertEquals(1, Season::count());


    }

    public function test_permitted_user_can_accept_season()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(1)->confirmation_status);

        $this->patch(route('seasons.accept', 1))->assertOk();

        $this->assertEquals(Season::CONFIRMATION_STATUS_ACCEPTED, Season::find(1)->confirmation_status);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test 2 season title",
            "number" => "2"
        ]);


        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);

        $this->patch(route('seasons.accept', 2))->assertStatus(403);

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);


    }

    public function test_permitted_user_can_reject_season()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(1)->confirmation_status);

        $this->patch(route('seasons.reject', 1))->assertOk();

        $this->assertEquals(Season::CONFIRMATION_STATUS_REJECTED, Season::find(1)->confirmation_status);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test 2 season title",
            "number" => "2"
        ]);


        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);

        $this->patch(route('seasons.reject', 2))->assertStatus(403);

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);


    }

    public function test_permitted_user_can_lock_season()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::STATUS_OPENED, Season::find(1)->status);

        $this->patch(route('seasons.lock', 1))->assertOk();

        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test 2 season title",
            "number" => "2"
        ]);


        $this->assertEquals(Season::STATUS_OPENED, Season::find(2)->status);

        $this->patch(route('seasons.lock', 2))->assertStatus(403);

        $this->assertEquals(Season::STATUS_OPENED, Season::find(2)->status);


    }
    public function test_permitted_user_can_unlock_season()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            "title" => "test season title",
            "number" => "1"
        ]);

        $this->assertEquals(1, Season::count());
        $this->patch(route('seasons.lock', 1))->assertOk();
        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);
        $this->patch(route('seasons.unlock', 1))->assertOk();
        $this->assertEquals(Season::STATUS_OPENED, Season::find(1)->status);

        $this->patch(route('seasons.lock', 1))->assertOk();


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->user()->id;
        $course->save();





        $this->patch(route('seasons.unlock', 1))->assertStatus(403);

        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);


    }

}
