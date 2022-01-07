@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center p-1 text-base font-bold'
    : 'inline-flex items-center p-1 text-sm font-bold leading-5 text-gray-500 hover:text-black';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
