<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use View;
use Log;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->company = \App\Models\Company::where('v2_domain_link', url(''))->first();
        if(!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', 'remapdash.com');
        Config::set('mail.mailers.smtp.port', 25);
        // Config::set('mail.mailers.smtp.encryption', 'ssl');
        Config::set('mail.mailers.smtp.username', 'passwrd-reset@remapdash.com');
        Config::set('mail.mailers.smtp.password', '4s29ih0L&');
        Config::set('mail.from.address', 'no-reply@remapdash.com');
        Config::set('mail.from.name', $this->company->name);
        Config::set('app.name', $this->company->name);
        Config::set('app.url', $this->company->v2_domain_link);
        Config::set('app.logo', asset('storage/uploads/logo/'.$this->company->logo));
        view()->share('company', $this->company);
        Log::info("Password Reset");
    }

    /**
     * customize the reset email form.
     *
     * @return mix
     */
    public function showLinkRequestForm()
    {
        return view('auth.admin.email');
    }

    /**
     * Handle a send reset link email request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function sendResetLinkEmail(Request $request)
    {

        $this->validate($request, ['email' => 'required|email']);

        $user_check = \App\Models\User::where('email', $request->email)->where('company_id', $this->company->id)->first();

        if($user_check){
            if($user_check->is_admin == 0){
                return redirect()->back()->with(['status'=>'error', 'message'=>__('auth.invalid_admin_privilege')]);
            }

            if($user_check->company_id != $this->company->id){
                return redirect()->back()->with(['status'=>'error', 'message'=>__('auth.invalid_domain')]);
            }
        }
        $response = $this->broker()->sendResetLink(
                    $request->only('email')
                );

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with(['status'=>'success', 'message'=>trans($response)]);
        }

        return back()->withErrors(
            ['email' => trans($response)]
        );
    }


    /**
     * Reset password broker.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function broker() {

        return Password::broker('admins');
    }
}
