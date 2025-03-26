@props(['active' => false])

@php
$classes = ($active ?? false)
? 'flex items-center px-4 py-3 text-sm font-medium'
: 'flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if (isset($icon))
    {{ $icon }}
    @endif
    {{ $slot }}
</a>
