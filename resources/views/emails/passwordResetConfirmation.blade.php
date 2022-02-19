@component('mail::message')

# Dear {{ $user->last_name ."," .$user->first_name }} <br>
Your password was recently changed

Thanks,<br>
{{ config('app.name') }}
@endcomponent
