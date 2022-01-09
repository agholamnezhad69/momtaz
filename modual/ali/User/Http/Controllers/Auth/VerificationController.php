<?php

namespace ali\User\Http\Controllers\Auth;

use ali\User\Http\Requests\verifyCodeRequest;
use ali\User\Services\verifyCodeService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | User that recently registered with the application. Emails may also
    | be re-sent if the User didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {

        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('User::front.verify');
    }

    public function verify(verifyCodeRequest $request)
    {


        $check = verifyCodeService::check(auth()->id(), $request->verify_code);

        if (!$check) return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد']);

        auth()->user()->markEmailAsVerified();
        return redirect()->route('home');


    }

    public function resend ()
    {
        dd("resend");
    }
}
