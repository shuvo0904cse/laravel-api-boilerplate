@component('mail::message')
# Dear {{ $user->last_name ."," .$user->first_name }} <br>

You need to verify your email account. <br>

@component('mail::button', ['url' => $link])
Verify Email
@endcomponent

If you did not request a password reset, no further action is required. <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
