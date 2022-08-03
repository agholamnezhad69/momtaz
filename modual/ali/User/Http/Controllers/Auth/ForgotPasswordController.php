<?php

namespace ali\User\Http\Controllers\Auth;

use ali\User\Http\Requests\resetPasswordVerifyCodeRequest;
use ali\User\Models\User;
use ali\User\Repositories\UserRepo;
use ali\User\Services\verifyCodeService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{


    use SendsPasswordResetEmails;

    public function showVerifyRequestForm()
    {
        return view('User::front.passwords.email');
    }

    public function sendVerifyCodeEmail(Request $request, UserRepo $userRepo)
    {


        $user = User::query()->where('mobile', $request->mobile)->first();


        if (is_null($user)) {
            return back()->withErrors(['mobile' => 'شماره همراه پیدا نشد']);
        } else {

            if (verifyCodeService::get($user->id)) {

                session()->flash("message", "کد تایید برای شما ارسال گردید. در صورت عدم دریافت، بعد از 1 دقیقه مجددا تلاش فرمایید. ");


            } else {


                session()->forget("message");

                $user->ResetPasswordRequestNotification();

            }
        }

        return view('User::front.passwords.enter-verify-code-form');
    }


    public function checkVerifyCode(resetPasswordVerifyCodeRequest $request)
    {


        $user = User::query()->where('mobile', $request->mobile)->first();

        if ($user == null || !verifyCodeService::check($user->id, $request->verify_code)) {

            return redirect()->back()
                ->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد !']);

        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');


    }


}
