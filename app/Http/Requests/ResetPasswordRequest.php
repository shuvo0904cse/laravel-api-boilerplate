<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email"                 => "required|email",
            "token"                 => "required",
            'password'              => 'required',
            'confirm_password'      => 'required|same:password'
        ];
    }
}
