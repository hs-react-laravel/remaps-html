<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use View;
use Log;
use App\Models\Api\ApiUser;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\APIPasswordReset;

class APIForgotPasswordController extends Controller
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

        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
        Config::set('mail.mailers.smtp.port', 25);
        // Config::set('mail.mailers.smtp.encryption', 'ssl');
        Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
        Config::set('mail.mailers.smtp.password', '5Cp38@gj2');
        Config::set('mail.from.address', 'no-reply@remapdash.com');
        Config::set('mail.from.name', $this->company->name);
        Config::set('app.name', $this->company->name);
        Config::set('app.url', "https://remapdash.com");
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
        return view('Frontend.api_forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {

        $this->validate($request, ['email' => 'required|email|exists:api_users']);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = ApiUser::where('email', $request->email)->first();

        try{
            Mail::to($user->email)->send(new APIPasswordReset($user, $token));
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }
}
