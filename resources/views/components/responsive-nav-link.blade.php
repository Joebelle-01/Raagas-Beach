@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sea-400 text-start text-base font-medium text-sea-700 bg-sea-50 focus:outline-none focus:text-sea-800 focus:bg-sea-100 focus:border-sea-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-sand-600 hover:text-sand-800 hover:bg-sand-50 hover:border-sand-300 focus:outline-none focus:text-sand-800 focus:bg-sand-50 focus:border-sand-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
