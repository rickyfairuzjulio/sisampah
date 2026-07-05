@props(['href'])

<a {{ $attributes->merge(['href' => $href ?? '#', 'class' => 'block w-full px-4 py-2.5 text-left text-sm font-medium text-on-surface hover:bg-surface-container-low transition-colors duration-150 focus:outline-none focus:bg-surface-container-low']) }}>
    {{ $slot }}
</a>
