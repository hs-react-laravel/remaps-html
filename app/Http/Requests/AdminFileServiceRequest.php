<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminFileServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('master')->check() || Auth::guard('admin')->check() || Auth::guard('staff')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':{
            }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'notes_by_engineer' => 'bail|nullable|string',
                    ];
                }
            default:break;
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::guard('admin')->user();
            if (Auth::guard('master')->check()) {
                $user = Auth::guard('master')->user();
            }
            if (Auth::guard('staff')->check()) {
                $user = Auth::guard('staff')->user();
            }
            if($user){
                if(!$user->company->owner->is_master){
                    if(!$user->company->owner->hasActiveSubscription()){
                        $validator->errors()->add('user', 'You havn\'t subscribed any plan or your plan hasn\'t active. Please subscribe any plan first.');
                    }
                }
            }
        });
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
