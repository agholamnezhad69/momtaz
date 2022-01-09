<?php

namespace ali\User\Http\Controllers\Auth;

use ali\User\Http\Requests\sendResetPasswordVerifyRequest;
use ali\User\Http\Requests\resetPasswordVerifyCodeRequest;
use ali\User\Repositories\UserRepo;
use ali\User\Services\verifyCodeService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use ali\User\Models\User;

class ForgotPasswordController extends Controller
{


    use SendsPasswordResetEmails;

    public function showVerifyRequestForm()
    {
        return view('User::front.passwords.email');
    }

    public function sendVerifyCodeEmail(sendResetPasswordVerifyRequest $request, UserRepo $userRepo)
    {


        $user = $userRepo->findByEmail($request->email);


        if (($user) && !(verifyCodeService::has($user->id))) {

            $user->ResetPasswordRequestNotification();

        }

        return view('User::front.passwords.enter-verify-code-form');


    }

    public function checkVerifyCode(resetPasswordVerifyCodeRequest $request)
    {


        $user = resolve(UserRepo::class)->findByEmail($request->email);


        if ($user == null || !verifyCodeService::check($user->id, $request->verify_code)) {

            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد !']);

        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');


    }


}
