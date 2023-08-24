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
    public function showResetForm(Request $request, $token = null)
    {
        return view('Frontend.api_forgot_reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
