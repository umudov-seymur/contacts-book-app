@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'pt-8 w-full rounded bg-blue-800 text-gray-100 outline-none focus:bg-blue-700']) !!}>
