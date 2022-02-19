@component('mail::message')
# Error Time

Message: {{ $exceptions['message'] }} <br>
File Name: {{ $exceptions['file_name'] }} <br>
Line Number: {{ $exceptions['line_number'] }} <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
