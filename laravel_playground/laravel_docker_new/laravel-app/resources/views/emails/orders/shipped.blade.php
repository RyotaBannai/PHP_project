@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => '', 'color' => 'success'])
Check your order.
@endcomponent

@component('mail::panel')
ここはパネルの内容です。
@endcomponent

@component('mail::table')
| Laravel       | テーブル      | 例       |
|:-------------:|:-------------:|:--------:|
| Col 2 is      | 中央寄せ      | $10      |
| Col 3 is      | 右寄せ        | $20      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endcomponent
