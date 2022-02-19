<?php

namespace App\Http\Requests;

class RegistrationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'            => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required',
            'confirm_password'      => 'required|same:password'
        ];
    }
}
