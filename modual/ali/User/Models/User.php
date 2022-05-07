<?php

namespace ali\User\Models;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use ali\Media\Models\Media;
use ali\RolePermissions\Models\Role;
use ali\User\Notifications\ResetPasswordRequestNotification;
use ali\User\Notifications\verifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;
    use HasRoles;
    use HasFactory;


    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";

    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN,

    ];


    public static $defaultUser = [
        [
            "email" => "admin@admin.com",
            "password" => "demo",
            "name" => "Admin",
            "role" => Role::ROLE_SUPER_ADMIN,
        ]
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendEmailVerificationNotification()
    {
        $this->notify(new verifyEmailNotification());

    }

    public function ResetPasswordRequestNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());

    }


    public function courses()
    {

        return $this->hasMany(Course::class, 'teacher_id');

    }

    public function seasons()
    {
        return $this->hasMany(Season::class, 'user_id');

    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);

    }



    public function profilePath()
    {

        return $this->username ? route("viewProfile", $this->username) : route("viewProfile", "username");

    }

    public function image()
    {

        return $this->belongsTo(Media::class, 'image_id');

    }

    public function getThumbAttribute()
    {

        if ($this->image)
            return "/storage/" . $this->image->files[300];
        return "/panel/img/profile.jpg/";


    }


    public function purchases()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');

    }

    public function studentCount()
    {


        return DB::table('courses')
            ->where('teacher_id', $this->id)
            ->join('course_user', 'courses.id', '=', 'course_user.course_id')
            ->count();

    }


}
