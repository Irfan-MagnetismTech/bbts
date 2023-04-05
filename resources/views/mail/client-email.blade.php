<x-mail::message>
Dear {{ $receiver }},

{!! $message !!}

@if(!empty($button))
@component('mail::button', ['url' => $button['url']])
{{ $button['text'] }}
@endcomponent
@endif
Thanks,<br>
{{ config('businessinfo.name') }}
</x-mail::message>
