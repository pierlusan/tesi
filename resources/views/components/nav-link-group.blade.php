@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-2 pb-2 mb-2 border-b-2 border-white text-base font-medium leading-5 text-white focus:outline-none focus:border-white transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-2 pb-2 mb-2 border-b-2 border-transparent text-base font-medium leading-5 text-stone-300 hover:text-white hover:border-stone-300 focus:outline-none focus:text-white focus:border-stone-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
