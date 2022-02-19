<?php

namespace App\Http\Requests;

class RolePermissionRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "permissions" => ['required', 'array']
        ];
    }
}
