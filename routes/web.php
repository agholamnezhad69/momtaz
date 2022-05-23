<?php

use ali\Payment\Events\PaymentWasSuccessfull;
use ali\Payment\Gateways\Gateway;
use ali\Payment\Models\Payment;


use ali\User\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\DB;

Route::get('/test', function () {


//    dd(now());


    /* $collection = collect([1, 2, 3, 4, 5]);


     dd($collection->contains(function ($key, $value) {
         return $value <= 6;
     }));*/

    /*dd(range(1, 10));*/


    /*dd(CarbonPeriod::create(now()->addDay(-30), now()));*/


    /* dd(
         DB::table('courses')
             ->where('teacher_id', 2)
             ->join('course_user', 'courses.id', '=', 'course_user.course_id')
             ->count()
     );*/


    /* event(new PaymentWasSuccessfull(new Payment()));*/


    /*   $payment = new Payment();*/
    /* $gateway = resolve(Gateway::class);*/

    /*$gateway->request($payment);*/

    /*return \ali\Media\Services\MediaFileService::getExtensions();*/
    /*\Spatie\Permission\Models\Permission::create(['name' => 'teach']);*/

    /*auth()->User()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);*/
    /*auth()->User()->assignRole('super admin');*/


    /*return auth()->user()->permissions;*/

});




