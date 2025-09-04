@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#5A4A42] dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
