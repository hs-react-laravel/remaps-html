<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use View;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    protected $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout', 'switchAsCompany', 'redirectFromMaster']);
        $this->company = \App\Models\Company::where('v2_domain_link', url(''))->first();
        if(!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        view()->share('company', $this->company);
    }

    /**
     * Reset the guard.
     *
     * @return \Illuminate\Http\Response
     */
    protected function guard() {
        return Auth::guard('admin');
    }

    /**
     * customize the login form.
     *
     * @return mix
     */
    public function showLoginForm()
    {
       return view('auth.admin.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

		$email = $request->get($this->username());
        $user = User::where($this->username(), $email)->where('company_id', $this->company->id)->first();
        if (!empty($user)) {
            if ($user->is_admin == 0 && $user->is_staff == null) {
                return redirect('admin/login')->with(['status'=>'error', 'error'=>__('auth.invalid_admin_privilege')]);
            }
			if ($user->is_active == 0) {
				return redirect('admin/login')->with(['status'=>'error', 'error'=>__('Your account is not verified yet, Please wait or Contact to administration. ')]);
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
        if ($user && $user->is_master) {
            return Auth::guard('master')->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        } else {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $email = $request->get($this->username());
        $user = User::where($this->username(), $email)->first();

        if ($user->is_master) {
            if ($response = $this->authenticated($request, Auth::guard('master')->user())) {
                return $response;
            }
        } else {
            if ($response = $this->authenticated($request, $this->guard()->user())) {
                return $response;
            }
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        $credentials = $request->only($this->username(), 'password');

        $email = $request->get($this->username());
        $user = User::where($this->username(), $email)->where('company_id', $this->company->id)->first();
        if ($user->is_master) {
            $credentials['is_master'] = 1;
            $credentials['is_admin'] = 1;
        } else {
            if ($user->is_admin) {
                $credentials['is_admin'] = 1;
            } else if ($user->is_staff) {
                $credentials['is_staff'] = 1;
            }
        }
        $credentials['company_id'] = $this->company->id;
        return $credentials;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request, $trans = 'auth.failed') {
        $errors = [$this->username() => trans($trans)];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors($errors);
    }

    /**
     * Switch account from admin to customer.
     * @param \App\Models\Company $company
     * @return response()
     */
    public function switchAsCompany(Request $request){
        try{
            $company = Company::find($request->id);
            if($company){
                return redirect()->away($company->v2_domain_link.'/admin/'.$request->id.'/redirect-from-master');
            }
        }catch(\Exception $e){
            \Alert::error(__('admin.opps'))->flash();
        }
        abort(404, __('admin.opps'));
    }

    public function redirectFromMaster(Request $request) {
        $company = Company::find($request->id);
        $user = $company->users()->where('is_master', 0)->where('is_admin', 1)->first();
        if($user){
            Auth::guard('admin')->login($user);
            return redirect('admin/dashboard');
        } else {
            return redirect('admin/login');
        }
    }

    /**
     * Remove user from session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $this->guard()->logout($request);
        return redirect('admin/login')->with(['status' => 'success', 'message' => __('auth.logged_out')]);
    }

}
