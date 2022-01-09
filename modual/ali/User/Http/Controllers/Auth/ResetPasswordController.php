<?php

namespace ali\User\Http\Controllers\Auth;

use ali\User\Http\Requests\changePasswordRequest;
use ali\User\Services\userService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function showResetForm(Request $request, $token = null)
    {

        return view('User::front.passwords.reset');


        return view('User::front.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(changePasswordRequest $request)
    {

        userService::changePassword(auth()->user(),$request->password);

        return redirect(route('home'));

    }
}
