<?php

namespace ali\Course\Tests\Feature;

use ali\Category\Models\Category;
use ali\Course\Models\Course;
use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
class CourseTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;
    private function createUser()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createCourse()
    {
        $data = $this->courseData() +
            [
                'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,
                'statues' => Course::STATUS_COMPLETED
            ];

        unset($data['status']);
        unset($data['image']);
        return Course::create($data);


    }

    private function actAsNormalUser()
    {
        $this->createUser();
    }

    private function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    private function actAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
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


    //permitted user can see curses index

    public function test_permitted_user_can_see_curses_index()
    {

        $this->actAsAdmin();
        $this->get(route('courses.index'))->assertOk();

        $this->actAsSuperAdmin();
        $this->get(route('courses.index'))->assertOk();

    }

    public function test_normal_user_can_not_see_curses_index()
    {

        $this->actAsNormalUser();
        $this->get(route('courses.index'))->assertStatus(403);

    }

    //permitted user can create curses

    public function test_permitted_user_can_create_curses()
    {
        $this->actAsAdmin();
        $this->get(route('courses.create'))->assertOk();

        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.create'))->assertOk();

    }

    public function test_normal_user_can_not_create_curses()
    {
        $this->actAsNormalUser();
        $this->get(route('courses.create'))->assertStatus(403);


    }

    //permitted user can edit curses
    public function test_permitted_user_can_edit_curses()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertOk();


        $this->actAsNormalUser();
        $course = $this->createCourse();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertOk();

    }

    public function test_normal_user_can_not_edit_curses()
    {

        $this->actAsNormalUser();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertStatus(403);


    }

    public function test_permitted_user_can_not_edit_others_users_curses()
    {

        $this->actAsNormalUser();
        echo("first user : " . auth()->user()->id);


        $course = $this->createCourse();
        echo("teacher id for course : " . $course->teacher_id);

        $this->actAsNormalUser();
        echo("second user : " . auth()->user()->id);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertStatus(403);

    }


    //permitted user can store curses

    public function test_permitted_user_can_store_course()
    {

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(
            [
                Permission::PERMISSION_MANAGE_OWN_COURSES,
                Permission::PERMISSION_TEACH
            ]);
        Storage::fake('local');
        $response = $this->post(route("courses.store"), $this->courseData());
        $response->assertRedirect(route('courses.index'));
        $this->assertEquals(Course::count(), 1);

    }

    //permitted user can update curses
    public function test_permitted_user_can_update_courses()
    {
        $this->withoutExceptionHandling();
        $this->actAsNormalUser();
        auth()->user()->givePermissionTo([Permission::PERMISSION_MANAGE_OWN_COURSES, Permission::PERMISSION_TEACH]);


        $course = $this->createCourse();


        $this->patch(route('courses.update', $course->id),
            [
                'teacher_id' => auth()->id(),
                'category_id' => $course->category->id,
                'title' => "update title",
                'slug' => "update slug",
                'priority' => 1,
                'price' => 1111,
                'percent' => 11,
                'type' => Course::TYPE_CASH,
                'image' => UploadedFile::fake()->image("banner.jpg"),
                'status' => Course::STATUS_NOT_COMPLETED
            ]
        )->assertRedirect(route('courses.index'));
        $course = $course->fresh();
        $this->assertEquals("update title", $course->title);


    }

    public function test_normal_user_can_not_update_courses()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);

        $this->patch(route('courses.update', $course->id),
            [
                'teacher_id' => auth()->id(),
                'category_id' => $course->category->id,
                'title' => "update title",
                'slug' => "update slug",
                'priority' => 1,
                'price' => 1111,
                'percent' => 11,
                'type' => Course::TYPE_CASH,
                'image' => UploadedFile::fake()->image("banner.jpg"),
                'status' => Course::STATUS_NOT_COMPLETED
            ]
        )->assertStatus(403);
    }


    //permitted user can delete course

    public function test_permitted_user_can_delete_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->delete(route('courses.destroy', $course->id))->assertOk();
        $this->assertEquals(0, $course->count());


    }

    public function test_normal_user_can_not_delete_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsNormalUser();

        $this->delete(route('courses.destroy', $course->id))->assertStatus(403);

        $this->assertEquals(1, $course->count());


    }

    //permitted user can confirmation status
    public function test_permitted_user_can_confirmation_status_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->patch(route('courses.accept', $course->id))->assertOk();
        $this->patch(route('courses.lock', $course->id))->assertOk();
        $this->patch(route('courses.reject', $course->id))->assertOk();

    }
    public function test_normal_user_can_not_confirmation_status_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->actAsNormalUser();
        $this->patch(route('courses.accept', $course->id))->assertStatus(403);
        $this->patch(route('courses.lock', $course->id))->assertStatus(403);
        $this->patch(route('courses.reject', $course->id))->assertStatus(403);

    }




    private function courseData()
    {
        $category = $this->createCategory();
        return [
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->sentence(2),
            'priority' => 12,
            'price' => 222,
            'percent' => 10,
            'type' => Course::TYPE_FREE,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image("banner.jpg"),
        ];
    }


}
