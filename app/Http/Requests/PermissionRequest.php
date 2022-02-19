<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PermissionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permissions = [
            'name' => ['required', 'string'],
            'route' => ['required', 'string', 'unique:permissions'],
            'type' => ['required', 'string'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $permissions['route'] = ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($this->permission)];
        }

        return $permissions;
    }
}
