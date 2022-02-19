@component('mail::message')
# Hello, <br>

Your email address {{ $subscription->email }} unsubscribed successfully. <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
