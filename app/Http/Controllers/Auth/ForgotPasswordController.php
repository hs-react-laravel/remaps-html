<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;
use App\Models\Company;

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
        if ($this->company->mail_host && $this->company->mail_port && $this->company->mail_encryption
            && $this->company->mail_username && $this->company->mail_password) {
            Config::set('mail.driver', $this->company->mail_driver);
            Config::set('mail.host', $this->company->mail_host);
            Config::set('mail.port', $this->company->mail_port);
            Config::set('mail.encryption', $this->company->mail_encryption);
            Config::set('mail.username', $this->company->mail_username);
            Config::set('mail.password', $this->company->mail_password);
            Config::set('mail.from.address', $this->company->mail_username);
            Config::set('mail.from.name', $this->company->name);
        } else {
            Config::set('mail.driver', 'smtp');
            Config::set('mail.host', 'mail.myremaps.com');
            Config::set('mail.port', 25);
            Config::set('mail.encryption', '');
            Config::set('mail.username', 'noreply@myremaps.com');
            Config::set('mail.password', 'Ig99ka%5');
            Config::set('mail.from.address', 'noreply@myremaps.com');
            Config::set('mail.from.name', '!Winston11!');
        }
        view()->share('company', $this->company);
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
