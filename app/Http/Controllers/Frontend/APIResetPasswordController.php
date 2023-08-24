<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use View;

class APIResetPasswordController extends Controller
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
    protected $redirectTo = '/api-dashboard';
    protected $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:apiusers');
        $this->company = \App\Models\Company::where('is_default', 1)->first();

        view()->share('company', $this->company);
    }

    /**
     * Reset the guard.
     *
     * @return \Illuminate\Http\Response
     */
    public function guard()
    {
        return Auth::guard('apiusers');
    }

    /**
     * customize the reset password form.
     *
     * @return mix
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('Frontend.api_forgot_reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset password broker.
     *
     * @return \Illuminate\Http\Response
     */
    public function broker() {
        return Password::broker('apiusers');
    }
}
