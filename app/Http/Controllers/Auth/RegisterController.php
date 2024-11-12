<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\TuningCreditGroup;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeCustomer;
use App\Mail\CustomerRegisterPending;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    protected $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->company = Company::where('v2_domain_link', url(''))->first();
        // $this->company = Company::find(1);
        if (!$this->company){
            abort(400, 'No such domain('.url("").') is registerd with system. Please contact to webmaster.');
        }
        view()->share('company', $this->company);
    }

    public function showRegistrationForm()
    {
        $langs = config('constants.langs');
        return view('auth.register', ['langs' => $langs]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $company = $this->company;
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'business_name' =>  'required|max:255',
            // 'email' => 'required|unique:users,email,NULL,id,company_id,'.$this->company->id.',deleted_at,NULL',
            'email' => ['required', 'string', 'email', 'max:191',Rule::unique('users')->where(function ($query) use ($company) {
                return $query->where('company_id', $company->id)->where('deleted_at', NULL);
            })],
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|required_with:password|min:6|max:20|same:password',
            'address_line_1' =>  'required|max:255',
            'county' =>  'required|max:255',
            'town' =>  'required|max:255',
            'phone' =>  'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $company  = $this->company;

		$data['company_id'] = $company->id;

        $defaultGroup = TuningCreditGroup::where('company_id', $this->company->id)
            ->where('group_type', 'normal')
            ->where('set_default_tier', 1)->first();

		$model = new User();
        $model->tuning_credit_group_id  =   $defaultGroup ? $defaultGroup->id : null;
        $model->private                 =   $data['private'];
        if ($model->private == 1) {
            $model->vat_number          =   $data['vat_number'];
        }
        $model->title                   =   $data['title'];
        $model->first_name              =   $data['first_name'];
        $model->last_name               =   $data['last_name'];
        $model->lang                    =   $data['lang'];
        $model->email                   =   $data['email'];
        // $model->password                =   Hash::make($data['password']);
        $model->business_name           =   $data['business_name'];
        $model->address_line_1          =   $data['address_line_1'];
        $model->address_line_2          =   $data['address_line_2'];
        $model->post_code               =   $data['post_code'];
        $model->county                  =   $data['county'];
        $model->town                    =   $data['town'];
        $model->phone                   =   $data['phone'];
        $model->tools                   =   $data['tools'];
        $model->company_id              =   $company->id;
        $model->is_verified             =   $this->company->is_accept_new_customer ? 1 : 0;

		$model->save();

        return $model;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $blocked = User::withTrashed()
            ->where('email', $request->input('email'))
            ->where('is_blocked', 1)
            ->first();

        if ($blocked) {
            return redirect()->route('register')->with(['status'=>'error', 'error'=> 'Blocked Account']);
        }

        $user = $this->create($request->all());

        // event(new Registered($user));

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        $token = app('auth.password.broker')->createToken($user);

        if ($this->company->is_accept_new_customer) {
            Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
        } else {
            Mail::to($user->email)->send(new CustomerRegisterPending($user));
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath())->with(['message'=>'Registration has been saved successfully.','status'=>'success']);
    }
}
