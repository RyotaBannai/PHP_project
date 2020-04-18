<h4>{{ $title }}</h4>

@props(['type' => 'info', 'message'])

<div alert-type="{{ $alertType }}" {{ $attributes }}>
    {{ $message }}
    {{$size}}
    {{ $slot }}
</div>
