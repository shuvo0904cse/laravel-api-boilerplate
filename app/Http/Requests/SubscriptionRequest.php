<?php

namespace App\Http\Requests;


class SubscriptionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $subscription = [
            'email' => ['required', 'email', 'unique:subscriptions'],
        ];

        return $subscription;
    }
}
