<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class personnelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account.phone_number'=>'max:13',
            'account.first_name' =>  'max:191',
            'account.last_name' =>  'max:191',
            'account.address' =>  'max:191',
            'account.email' => 'required|max:191|email|unique:users,email,',
        ];
    }
}
