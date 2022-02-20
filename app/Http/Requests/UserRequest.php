<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name'            => ['required', 'string', 'max:255'],
            'last_name'             => ['string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users', 'max:255'],
            'password'              => ['required', 'min:6', 'same:password_confirmation', 'max:255'],
            'password_confirmation' => ['required', 'min:6']
        ];
    
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->email)];
        }
    
        return $rules;
    }
}
