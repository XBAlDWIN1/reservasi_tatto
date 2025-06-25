@props(['label', 'name', 'accept' => '', 'required' => false])

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        accept="{{ $accept }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'mt-1 block w-full text-sm text-gray-700 border rounded px-3 py-2']) }}>
    @error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>