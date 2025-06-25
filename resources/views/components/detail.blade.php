@props(['label', 'value' => null])

<div {{ $attributes->merge(['class' => '']) }}>
    <dt class="font-medium text-gray-600">{{ $label }}</dt>
    <dd class="mt-1">{{ $value ?? $slot }}</dd>
</div>