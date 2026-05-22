@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sea-400 text-sm font-medium leading-5 text-sand-900 focus:outline-none focus:border-sea-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-sand-500 hover:text-sand-700 hover:border-sand-300 focus:outline-none focus:text-sand-700 focus:border-sand-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
