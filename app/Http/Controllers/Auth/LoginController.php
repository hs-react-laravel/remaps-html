<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->company = Company::where('v2_domain_link', url(''))->first();
        if (!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        view()->share('company', $this->company);
    }
    protected function guard()
    {
        return Auth::guard('customer');
    }
    public function login(Request $request) {

        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $email = $request->get($this->username());
        $user = User::where($this->username(), $email)->where('company_id', $this->company->id)->first();
        if (!empty($user)) {
            if ($user->is_admin == 1) {
                return redirect()->route('login')->with(['status'=>'error', 'error'=>__('auth.invalid_customer_privilege')]);
            }
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        $email = $request->get($this->username());
        $user = User::where($this->username(), $email)->where('company_id', $this->company->id)->first();
        if ($user && $user->is_staff) {
            return Auth::guard('staff')->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        } else {
            $res = $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
            dd($res);
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $email = $request->get($this->username());
        $user = User::where($this->username(), $email)->where('company_id', $this->company->id)->first();

        if ($user->is_staff) {
            $this->redirectTo = '/staff/dashboard';
            if ($response = $this->authenticated($request, Auth::guard('staff')->user())) {
                return $response;
            }
        } else {
            $this->redirectTo = '/customer/dashboard';
            if ($response = $this->authenticated($request, $this->guard()->user())) {
                return $response;
            }
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request) {
        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout($request);
        } else {
            $this->guard()->logout($request);
        }
        return redirect()->route('login')->with(['status' => 'success', 'message' => __('auth.logged_out')]);
    }
}
