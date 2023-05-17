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
            Config::set('mail.default', $this->company->mail_driver);
            Config::set('mail.mailers.host', $this->company->mail_host);
            Config::set('mail.mailers.port', $this->company->mail_port);
            Config::set('mail.mailers.encryption', $this->company->mail_encryption);
            Config::set('mail.mailers.username', $this->company->mail_username);
            Config::set('mail.mailers.password', $this->company->mail_password);
            Config::set('mail.from.address',$this->company->mail_username );
        } else {
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.host', 'mail.remapdash.com');
            Config::set('mail.mailers.port', 25);
            Config::set('mail.mailers.encryption', '');
            Config::set('mail.mailers.username', 'passwrd-reset@remapdash.com');
            Config::set('mail.mailers.password', '4s29ih0L&');
            Config::set('mail.from.address', 'passwrd-reset@remapdash.com');
        }
        Config::set('mail.from.name', $this->company->name);
        Config::set('app.name', $this->company->name);
        Config::set('app.url', $this->company->v2_domain_link);
        Config::set('app.logo', asset('storage/uploads/logo/'.$this->company->logo));
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
