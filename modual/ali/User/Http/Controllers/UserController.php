<?php

namespace ali\User\Http\Controllers;

use ali\Common\Responses\AjaxResponses;
use ali\Media\Services\MediaFileService;
use ali\RolePermissions\Repositories\RoleRepo;
use ali\User\Http\Requests\AddRoleRequest;
use ali\User\Http\Requests\UpdateProfileInformationRequest;
use ali\User\Http\Requests\UpdateUserPhotoRequest;
use ali\User\Http\Requests\UpdateUserRequest;
use ali\User\Models\User;
use ali\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;

class UserController extends Controller

{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(RoleRepo $roleRepo)
    {
        $this->authorize('index', User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view("User::admin.index", compact('users', 'roles'));
    }

    public function addRole(AddRoleRequest $request, User $user)
    {
        $this->authorize('addRole', User::class);

        $user->assignRole($request->role);

        newFeedbacks(
            "موفقیت آمیز",
            "نقش کاربری{$request->role} به کاربر {$user->name} داده شد",
            "success"
        );

        return back();

    }

    public function removeRole($userId, $role)
    {
        $this->authorize('removeRole', User::class);
        $user = $this->userRepo->finById($userId);
        $user->removeRole($role);
        return AjaxResponses::successResponse();


    }

    public function edit($userId)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->finById($userId);
        return view("User::admin.edit", compact("user"));

    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->finById($userId);
        if ($request->hasFile('image')) {
            $request->request->add(
                ['image_id' => MediaFileService::upload($request->file('image'))->id]
            );
            if ($user->image) {
                $user->image->delete();
            }
        } else {
            $request->request->add(['image_id' => $user->image_id]);
        }

        $this->userRepo->update($userId, $request);
        newFeedbacks();
        return redirect()->back();


    }

    public function destroy($userId)
    {
        $this->authorize('delete', User::class);
        $user = $this->userRepo->finById($userId);
        $user->delete();
        AjaxResponses::successResponse();


    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify', User::class);
        $user = $this->userRepo->finById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::successResponse();

    }

    public function updatePhoto(UpdateUserPhotoRequest $request)
    {
        $media = MediaFileService::upload($request->file('userPhoto'));
        if (auth()->user()->image) {
            auth()->user()->image->delete();
        }
        auth()->user()->image_id = $media->id;
        auth()->user()->save();
        newFeedbacks();
        return back();


    }

    public function profile()
    {
        $this->authorize('editProfile', User::class);
        return view("User::admin.profile");

    }

    public function updateProfile(UpdateProfileInformationRequest $request)
    {
        $this->authorize('editProfile', User::class);
        $this->userRepo->updateProfile($request);
        newFeedbacks();
        return back();

    }

    public function show()
    {
        return abort(404);
    }


}
