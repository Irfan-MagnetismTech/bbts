<x-mail::message>
Dear {{ $receiver }},

{{ $message }}

Thanks,<br>
{{ config('businessinfo.name') }}
</x-mail::message>
