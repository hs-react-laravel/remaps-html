<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::find($this->get('id'));
        $admin = Auth::user();
        switch ($this->method()) {
            case 'GET':{
                return [
                    'first_name'      => 'required|string|max:191',
                    'last_name'       => 'required|string|max:191',
                    'email'           => 'required|email|unique:users,email',
                ];
            }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'first_name'      => 'required|string|max:191',
                        'last_name'       => 'required|string|max:191',
                        'email'           => 'required|email|unique:users,email,NULL,id,company_id,'.$admin->company->id
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'first_name'      => 'required|string|max:191',
                        'last_name'       => 'required|string|max:191',
                        'email'           => 'required|email|unique:users,email,'.$user->id.',id,company_id,'.$admin->company->id,
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
