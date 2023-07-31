<?php

namespace App\Http\Controllers\Auth\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
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

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->company = Company::where('v2_domain_link', url(''))->first();
        if (!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
        Config::set('mail.mailers.smtp.port', 25);
        // Config::set('mail.mailers.smtp.encryption', 'ssl');
        Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
        Config::set('mail.mailers.smtp.password', '5Cp38@gj2');
        Config::set('mail.from.address', 'no-reply@remapdash.com');
        Config::set('mail.from.name', $this->company->name);
        Config::set('app.name', $this->company->name);
        Config::set('app.url', $this->company->v2_domain_link);
        Config::set('app.logo', asset('storage/uploads/logo/'.$this->company->logo));
        view()->share('company', $this->company);
        Log::info("Password Reset");
    }
    /**
     * Reset password broker.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function broker() {

        return Password::broker('customers');
    }
}
