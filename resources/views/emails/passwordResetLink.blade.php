@component('mail::message')
# Dear {{ $user->last_name ."," .$user->first_name }} <br>

You are receiving this email because we received a password reset request for your account. <br>

@component('mail::button', ['url' => $link])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes. <br>

If you did not request a password reset, no further action is required. <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
