@props(['active' => false])

@php
$baseClasses = 'flex items-center px-4 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out';
$activeClasses = 'bg-[#FFCDB2] text-black';
$inactiveClasses = 'text-gray-700 hover:bg-[#FFCDB2] hover:text-black';

$classes = $active ? "$baseClasses $activeClasses" : "$baseClasses $inactiveClasses";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon ?? '' }}
    {{ $slot }}
</a>
