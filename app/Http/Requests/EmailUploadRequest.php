<?php

namespace App\Http\Requests;

class EmailUploadRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'mimes:csv,txt'],
        ];
    }
}
