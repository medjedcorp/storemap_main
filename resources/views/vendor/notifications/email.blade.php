@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
{{-- # お知らせ --}}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{-- @lang('Regards'),<br> --}}
{{-- {{ config('app.name') }} --}}
{{ config('app.name') }} より
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    // "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    // 'into your web browser:',
    "もし、「:actionText」ボタンがうまく機能しない場合、以下のURLをコピー＆ペーストして\n".
    '直接ブラウザからアクセスしてください。',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
