<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TuningCreditTireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('master')->check() || Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->user = Auth::guard('admin')->user();
        if (Auth::guard('master')->check()) {
            $this->user = Auth::guard('master')->user();
        }

        switch ($this->method()) {
            case 'GET':{
                return [

                ];
            }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'amount' =>'required|'.Rule::unique('tuning_credit_tires')->where('company_id', $this->user->company_id)->where('group_type', 'normal')->whereNull('deleted_at').'|regex:/^\d*(\.\d{1,2})?$/|max:8',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:8',
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
