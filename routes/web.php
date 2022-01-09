<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use ali\RolePermissions\Models\Permission;


Route::get('/', function () {
    return view('index');
});

Route::get('/test', function () {

    /*\Spatie\Permission\Models\Permission::create(['name' => 'teach']);*/

    auth()->User()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
   /*auth()->User()->assignRole('super admin');*/


    return auth()->user()->permissions;

});




