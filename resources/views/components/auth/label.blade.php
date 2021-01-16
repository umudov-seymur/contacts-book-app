@props(['value'])

<label {{ $attributes->merge(['class' => 'uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2']) }}>
    {{ $value ?? $slot }}
</label>
