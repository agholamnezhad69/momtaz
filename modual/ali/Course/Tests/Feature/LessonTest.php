<?php

namespace ali\Course\Tests\Feature;

use ali\Category\Models\Category;
use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LessonTest extends TestCase
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
    private function createLesson($course)
    {
        return Lesson::query()->create([
            "course_id" => $course->id,
            "user_id" => auth()->user()->id,
            "title" => "lesson one",
            "slug" => "lesson one",
        ]);
    }
    public function test_user_can_see_create_lesson_form()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->get(route('lessons.create', $course->id))->assertOk();


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();


    }
    public function test_user_can_not_see_create_lesson_form()
    {


        $this->actAsAdmin();
        $course = $this->createCourse();


        $this->actAsNormalUser();
        $this->get(route('lessons.create', $course->id))->assertStatus(403);

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('lessons.create', $course->id))->assertStatus(403);

    }
    public function test_permitted_user_can_store_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('lessons.store', $course->id), [
            "title" => "title one",
            "time" => "20",
            "is_free" => "1",
            "lesson_file" => UploadedFile::fake()->create("film.mp4", 1024)
        ]);

        $this->assertEquals(1, Lesson::query()->count());


    }
    public function test_permitted_user_can_not_store_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsNormalUser();
        $this->post(route('lessons.store', $course->id), [
            "title" => "title one",
            "time" => "20",
            "is_free" => "1",
            "lesson_file" => UploadedFile::fake()->create("film.mp4", 1024)
        ]);

        $this->assertEquals(0, Lesson::query()->count());

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->post(route('lessons.store', $course->id), [
            "title" => "title one",
            "time" => "20",
            "is_free" => "1",
            "lesson_file" => UploadedFile::fake()->create("film.mp4", 1024)
        ]);

        $this->assertEquals(0, Lesson::query()->count());


    }
    public function test_only_allowed_extensions_can_be_uploaded()
    {

        $notAllowedExtension = ['jpg', 'png', 'mp3'];
        $this->actAsAdmin();
        $course = $this->createCourse();

        foreach ($notAllowedExtension as $extension) {
            $this->post(route('lessons.store', $course->id), [
                "title" => "title one",
                "time" => "20",
                "is_free" => "1",
                "lesson_file" => UploadedFile::fake()->create("film." . $extension, 1024)
            ]);

        }
        $this->assertEquals(0, Lesson::query()->count());
    }
    public function test_permitted_user_can_see_edit_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);

        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();





    }
    public function test_permitted_user_can_not_see_edit_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);



        $this->actAsNormalUser();
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertStatus(403);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertStatus(403);





    }

}
