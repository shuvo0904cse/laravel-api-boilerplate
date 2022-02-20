<?php

namespace App\Http\Requests;


class UnSubscriptionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $subscription = [
            'email' => ['required', 'email'],
        ];

        return $subscription;
    }
}
