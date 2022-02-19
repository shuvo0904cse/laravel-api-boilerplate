@component('mail::message')

# Dear {{ $user->last_name ."," .$user->first_name }} <br>
User Email Verified successfully.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
