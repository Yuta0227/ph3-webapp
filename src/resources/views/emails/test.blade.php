@component('mail::message')
{{-- {{ $name }}様
{{ $content }} --}}
お問い合わせありがとうございました。
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
