@component('mail::message')
# Personal site message

{{ $data['subject'] }}

<hr>

{{ $data['comment'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
