<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class EmailRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => ['required', 'email', 'unique:emails'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'] = ['required', 'email', Rule::unique('emails')->ignore($this->email)];
        }

        return $rules;
    }
}
