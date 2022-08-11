<?php

namespace ali\Comment\Tests\Feature;


use ali\Category\Models\Category;
use ali\Comment\Models\Comment;
use ali\Course\Models\Course;
use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class CommentTest extends TestCase
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
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COMMENTS);
    }

    private function actAsNormalUser()
    {
        $this->createUser();
    }

    public function test_permitted_user_can_see_comments_index()
    {
        $this->actAsSuperAdmin();
        $this->get(route("comments.index"))->assertOk();

        $this->actAsAdmin();
        $this->get(route("comments.index"))->assertOk();

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);
        $this->get(route("comments.index"))->assertOk();

    }

    public function test_permitted_user_can_not_see_comments_index()
    {


        $this->actAsNormalUser();

        $this->get(route("comments.index"))->assertStatus(403);

    }

    public function test_user_can_store_comment()
    {
        $this->actAsNormalUser();
        $course = $this->createCourse();
        $this->post(route("comments.store"),
            [
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "comment_id" => "",
                "body" => "my first test comment",
            ]
        )->assertRedirect();
        $this->assertEquals(1, Comment::query()->count());
    }

    public function test_user_can_reply_to_approved_comment()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route("comments.store"),
            [
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "comment_id" => "",
                "body" => "my first test comment",
            ]
        )->assertRedirect();

        $this->assertEquals(1, Comment::query()->count());

        $this->post(route("comments.store"),
            [
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "comment_id" => 1,
                "body" => "my first answer test comment",
            ]
        )->assertRedirect();
        $this->assertEquals(2, Comment::query()->count());


    }

    public function test_user_can_not_reply_to_unapproved_comment()
    {
        $this->actAsNormalUser();
        $course = $this->createCourse();
        $this->post(route("comments.store"),
            [
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "comment_id" => "",
                "body" => "my first test comment",
            ]
        )->assertRedirect();

        $this->assertEquals(1, Comment::query()->count());

        $this->post(route("comments.store"),
            [
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "comment_id" => 1,
                "body" => "my first answer test comment",
            ]
        )->assertRedirect();

        $this->assertEquals(1, Comment::query()->count());


    }

    public function test_user_can_remove_comment()
    {
        $this->actAsAdmin();

        $comment = $this->createComment();

        $this->assertEquals(1, Comment::query()->count());

        $this->delete(route('comments.destroy', $comment->id))->assertOk();
        $this->assertEquals(0, $comment->count());


    }

    public function test_user_can_not_remove_comment()
    {
        $this->actAsAdmin();
        $comment = $this->createComment();
        $this->assertEquals(1, Comment::query()->count());


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);


        $this->delete(route('comments.destroy', $comment->id))->assertStatus(403);
        $this->assertEquals(1, $comment->count());


    }

    public function test_user_can_approved_comment()
    {
        $this->actAsAdmin();

        $comment = $this->createComment();

        $this->assertEquals(1, Comment::query()->count());

        $this->patch(route('comments.accept', $comment->id))->assertOk();



    }
    public function test_user_can_not_approved_comment()
    {
        $this->actAsAdmin();
        $comment = $this->createComment();
        $this->assertEquals(1, Comment::query()->count());


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);


        $this->patch(route('comments.accept', $comment->id))->assertStatus(403);


    }

    public function test_user_can_reject_comment()
    {
        $this->actAsAdmin();

        $comment = $this->createComment();

        $this->assertEquals(1, Comment::query()->count());

        $this->patch(route('comments.reject', $comment->id))->assertOk();



    }
    public function test_user_can_not_reject_comment()
    {
        $this->actAsAdmin();
        $comment = $this->createComment();
        $this->assertEquals(1, Comment::query()->count());


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);


        $this->patch(route('comments.reject', $comment->id))->assertStatus(403);


    }

    public function test_user_can_see_show_comment()
    {
        $this->actAsAdmin();
        $comment = $this->createComment();
        $this->assertEquals(1, Comment::query()->count());
        $this->get(route('comments.show', $comment->id))->assertOk();

        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);
        $comment = $this->createComment();
        $this->get(route('comments.show', $comment->id))->assertOk();



    }
    public function test_user_can_not_see_show_comment()
    {
        $this->actAsAdmin();
        $comment = $this->createComment();
        $this->assertEquals(1, Comment::query()->count());

        $this->actAsNormalUser();
        $this->get(route('comments.show', $comment->id))->assertStatus(403);


        $this->actAsNormalUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);
        $this->get(route('comments.show', $comment->id))->assertStatus(403);


    }

    private function createComment()
    {
        $course = $this->createCourse();
        return Comment::query()->create(
            [
                "user_id" => auth()->id(),
                "commentable_type" => get_class($course),
                "commentable_id" => $course->id,
                "body" => "my first test comment",
                "status" =>
                    auth()->user()->can(Permission::PERMISSION_MANAGE_COMMENTS) ||
                    auth()->user()->can(Permission::PERMISSION_TEACH)
                        ?
                        Comment::STATUS_APPROVED
                        :
                        Comment::STATUS_NEW
            ]
        );
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

    private function courseData()
    {
        $category = $this->createCategory();
        return [
            'title' => $this->faker->sentence(2),
            "slug" => $this->faker->sentence(2),
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            "priority" => 12,
            "price" => 1200,
            "percent" => 70,
            "type" => Course::TYPE_FREE,
            "image" => UploadedFile::fake()->image('banner.jpg'),
            "status" => Course::STATUS_COMPLETED,
        ];
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


}
