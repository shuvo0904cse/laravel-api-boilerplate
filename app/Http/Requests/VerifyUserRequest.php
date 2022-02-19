<?php

namespace App\Http\Requests;

class VerifyUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email"  => "required|email",
            "token"  => "required"
        ];
    }
}
