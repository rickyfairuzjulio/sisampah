@props(['percent' => 0, 'color' => 'primary'])

<div {{ $attributes->merge(['class' => 'w-full h-[8px] bg-secondary-fixed rounded-full overflow-hidden']) }}>
    <div class="h-full bg-{{ $color }} rounded-r-full transition-all duration-500 ease-in-out" style="width: {{ $percent }}%"></div>
</div>
