<?php

namespace App\Http\Requests;

use App\Helpers\Message;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Failed Validation
     */
    protected function failedValidation(Validator $validator)
    {
        Message::httpResponseException($validator->errors());
    }
}
