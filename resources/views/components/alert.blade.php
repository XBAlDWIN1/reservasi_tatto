@props(['type' => 'success'])

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="p-4 mb-4 text-sm rounded-lg relative transition-opacity duration-500
     {{ $type === 'success' ? 'bg-green-100 text-green-700' : ($type === 'error' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">

    <div>
        {{ $slot }}
    </div>

    <div class="absolute top-2 right-2">
        {{ $close ?? '' }}
    </div>
</div>