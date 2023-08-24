<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use View;
use DB;
use Hash;
use App\Models\Api\ApiUser;

class APIResetPasswordController extends Controller
{
    protected $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->company = \App\Models\Company::where('is_default', 1)->first();

        view()->share('company', $this->company);
    }

    /**
     * customize the reset password form.
     *
     * @return mix
     */
    public function showResetForm(Request $request)
    {
        return view('Frontend.api_forgot_reset')->with(
            ['token' => $request->token, 'email' => $request->email]
        );
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:api_users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = ApiUser::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/api-login')->with('success', 'Your password has been changed!');
    }
}
