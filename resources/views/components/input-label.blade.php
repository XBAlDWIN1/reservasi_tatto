@props(['value', 'variant' => 'default'])

@php
$baseClass = 'block font-semibold text-sm mb-2';
$variantClass = match($variant) {
'default' => 'text-accent',
'error' => 'text-red-600',
'success' => 'text-green-600',
'warning' => 'text-yellow-600',
'muted' => 'text-gray-400',
'primary' => 'text-gray-700',
default => 'text-accent',
};
@endphp

<label {{ $attributes->merge(['class' => "$baseClass $variantClass"]) }}>
    {{ $value ?? $slot }}
</label>