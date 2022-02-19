@component('mail::message')
# Hello, <br>

Your email address {{ $subscription->email }} subscribed successfully. <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
