<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AccountStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return (Auth::guard('admin')->check() || Auth::guard('customer')->check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::find($this->get('user_id'));

        switch ($this->method()) {
            case 'GET':{
                return [
                    'first_name'      => 'required|string|min:3|max:191',
                    'last_name'       => 'required|string|min:3|max:191',
                    'phone'           => 'required|string|min:7',
                    'email'           => 'required|email|unique:users,email',
                ];
            }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'first_name'      => 'required|string|min:3|max:191',
                        'last_name'       => 'required|string|min:3|max:191',
                        'phone'           => 'required|string|min:7',
                        'email'           => 'required|email|unique:users,email,'.$user->id.',id',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'first_name'      => 'required|string|min:3|max:191',
                        'last_name'       => 'required|string|min:3|max:191',
                        'post_code'       => 'nullable|string|min:5|max:7',
                        'email'           => 'required|email|unique:users,email,'.$user->id.',id',
                    ];
                }
            default:break;
        }
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
