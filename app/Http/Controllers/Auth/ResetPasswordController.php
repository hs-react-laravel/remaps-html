<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;

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
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:customer');
        $this->company = Company::where('domain_link', url(''))->first();
        if (!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        view()->share('company', $this->company);
    }

    public function broker() {
        return Password::broker('customers');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    // public function resetPassword($user, $password)
    // {
    //     $this->setUserPassword($user, $password);
    //     $user->setRememberToken(Str::random(60));
    //     $user->save();
    //     event(new PasswordReset($user));
    // }
}
