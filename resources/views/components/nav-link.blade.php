@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-3 mb-2.5 border-b-2 border-stone-50 text-sm font-medium leading-5 text-stone-50 focus:outline-none focus:border-stone-100 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-3 mb-2.5 border-b-2 border-transparent text-sm font-medium leading-5 text-stone-200 hover:text-stone-100 hover:border-stone-100 focus:outline-none focus:text-stone-50 focus:border-stone-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
