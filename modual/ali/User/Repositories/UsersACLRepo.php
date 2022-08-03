<?php


namespace ali\User\Repositories;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use ali\RolePermissions\Models\Permission;


class UsersACLRepo implements ACLRepository
{


    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN)) {
            return [
                ['disk' => 'public_html', 'path' => '/', 'access' => 1],                                  // main folder - read
                ['disk' => 'public_html', 'path' => 'img', 'access' => 1],                              // only read
                ['disk' => 'public_html', 'path' => 'img/*', 'access' => 2],        // only read
                ['disk' => 'public_html', 'path' => 'img/*', 'access' => 2],  // read and write




                ['disk' => 'storage_private', 'path' => '*', 'access' => 2],
                ['disk' => 'storage_public', 'path' => '*', 'access' => 2],
                ['disk' => 'download_host', 'path' => '*', 'access' => 2],


            ];
        } else if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {

            return [

                ['disk' => 'storage_private', 'path' => '/', 'access' => 1],                                  // main folder - read
                ['disk' => 'storage_private', 'path' => 'teacherCourse', 'access' => 1],                              // only read
                ['disk' => 'storage_private', 'path' => 'teacherCourse/' . \Auth::user()->username, 'access' => 1],        // only read
                ['disk' => 'storage_private', 'path' => 'teacherCourse/' . \Auth::user()->username . '/*', 'access' => 2],  // read and write


                ['disk' => 'public_html', 'path' => '/', 'access' => 1],                                  // main folder - read
                ['disk' => 'public_html', 'path' => 'img', 'access' => 1],                              // only read
                ['disk' => 'public_html', 'path' => 'img/' . \Auth::user()->username, 'access' => 1],        // only read
                ['disk' => 'public_html', 'path' => 'img/' . \Auth::user()->username . '/*', 'access' => 2],  // read and write


                ['disk' => 'public_html', 'path' => '/', 'access' => 1],                                  // main folder - read
                ['disk' => 'public_html', 'path' => 'img/users', 'access' => 1],                              // only read
                ['disk' => 'public_html', 'path' => 'img/users/' . \Auth::user()->username, 'access' => 1],        // only read
                ['disk' => 'public_html', 'path' => 'img/users/' . \Auth::user()->username . '/*', 'access' => 2],  // read and write


            ];

        }

        return [];


    }
}
