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

    public function test_permitted_user_can_see_create_lesson_form()
    {

        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->get(route('lessons.create', $course->id))->assertOk();


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();


    }

    public function test_normal_user_can_not_see_create_lesson_form()
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

    public function test_normal_user_can_not_store_lesson()
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

    public function test_normal_user_can_not_see_edit_form()
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


    public function test_permitted_user_can_update_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);


        $this->patch(route('lessons.update', [$course->id, $lesson->id]), [
            "title" => "update title one",
            "time" => "20",
            "is_free" => "1",
        ]);

        $this->assertEquals("update title one", Lesson::find(1)->title);


    }

    public function test_normal_user_can_not_update_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);


        $this->actAsNormalUser();
        $this->patch(route('lessons.update', [$course->id, $lesson->id]), [
            "title" => "update title one",
            "time" => "20",
            "is_free" => "1",
        ]);

        $this->assertEquals("lesson one", Lesson::find(1)->title);

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.update', [$course->id, $lesson->id]), [
            "title" => "update title one",
            "time" => "20",
            "is_free" => "1",
        ]);

        $this->assertEquals("lesson one", Lesson::find(1)->title);


    }

    public function test_permitted_user_can_accept_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);

        $this->patch(route('lessons.accept', $lesson->id));

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);


    }

    public function test_normal_user_can_not_accept_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);


        $this->actAsNormalUser();
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);

    }

    public function test_permitted_user_can_accept_all_lessons()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();

        $lesson1 = $this->createLesson($course1);
        $lesson2 = $this->createLesson($course1);

        $course2 = $this->createCourse();
        $lesson3 = $this->createLesson($course2);


        $this->patch(route('lessons.acceptAll', $course1->id));



        $this->assertEquals($course1->lessons()->count(),
            Lesson::query()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)->count()
        );

        $this->assertEquals($course2->lessons()->count(),
            Lesson::query()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count()
        );


    }

    public function test_normal_user_can_not_accept_all_lessons()
    {

        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $lesson1 = $this->createLesson($course1);
        $lesson2 = $this->createLesson($course1);




        $this->actAsNormalUser();
        $this->patch(route('lessons.acceptAll', $course1->id))->assertStatus(403);
        $this->assertEquals($course1->lessons()->count(),
            Lesson::query()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count()
        );

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.acceptAll', $course1->id))->assertStatus(403);
        $this->assertEquals($course1->lessons()->count(),
            Lesson::query()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count()
        );
    }

    public function test_permitted_user_can_reject_lesson()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $lesson1 = $this->createLesson($course1);

        $this->patch(route('lessons.reject', $course1->id));
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);


    }
    public function test_normal_user_can_not_reject_lesson()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $lesson1 = $this->createLesson($course1);

        $this->actAsNormalUser();
        $this->patch(route('lessons.reject', $course1->id))->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.reject', $course1->id))->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
    }
    public function test_permitted_user_can_accept_multiple_lessons()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.acceptMultiple', $course->id), [
            "ids" => '1,2'
        ]);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);


    }
    public function test_normal_user_can_not_accept_multiple_lessons()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);



        $this->actAsNormalUser();
        $this->patch(route('lessons.acceptMultiple', $course->id), [
            "ids" => '1,2'
        ])->assertStatus(403);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);

        $this->patch(route('lessons.acceptMultiple', $course->id), [
            "ids" => '1,2'
        ])->assertStatus(403);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);
    }

    public function test_permitted_user_can_reject_multiple_lessons()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.rejectMultiple', $course->id), [
            "ids" => '1,2'
        ]);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);


    }
    public function test_normal_user_can_not_reject_multiple_lessons()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);

        $this->actAsNormalUser();
        $this->patch(route('lessons.rejectMultiple', $course->id), [
            "ids" => '1,2,3'
        ])->assertStatus(403);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);


        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.rejectMultiple', $course->id), [
            "ids" => '1,2,3'
        ])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

    }
    public function test_permitted_user_can_lock_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.lock', 1));
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

    }
    public function test_normal_user_can_not_lock_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.lock', 1));
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        $this->actAsNormalUser();
        $this->patch(route('lessons.lock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.lock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);
    }

    public function test_permitted_user_can_unlock_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->patch(route('lessons.lock', 1));
        $this->patch(route('lessons.lock', 2));
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);

        $this->patch(route('lessons.unlock', 1));
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        $this->actAsNormalUser();
        $this->patch(route('lessons.unlock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.unlock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);
    }

    public function test_permitted_user_can_destroy_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->delete(route('lessons.destroy', [1, 1]))->assertStatus(200);
        $this->assertEquals(null, Lesson::find(1));

        $this->actAsNormalUser();
        $this->delete(route('lessons.destroy', [1, 2]))->assertStatus(403);
        $this->assertEquals(1, Lesson::where('id', 2)->count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);

        $this->delete(route('lessons.destroy', [1, 2]))->assertStatus(403);
        $this->assertEquals(1, Lesson::where('id', 2)->count());
    }
    public function test_permitted_user_can_destroy_multiple_lessons()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);

        $this->delete(route('lessons.destroyMultiple', $course->id), [
            "ids" => '1,2'
        ]);

        $this->assertEquals(null, Lesson::find(1));
        $this->assertEquals(null, Lesson::find(2));
        $this->assertEquals(3, Lesson::find(3)->id);

        $this->actAsNormalUser();
        $this->delete(route('lessons.destroyMultiple', $course->id), [
            "ids" => '3'
        ])->assertStatus(403);
        $this->assertEquals(3, Lesson::find(3)->id);
    }

}
