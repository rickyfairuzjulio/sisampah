@props(['title' => '', 'subtitle' => ''])

<div {{ $attributes->merge(['class' => 'rounded-xl overflow-hidden shadow-ambient bg-gradient-to-br from-primary to-primary-container p-lg text-on-primary']) }}>
    <div class="flex flex-col space-y-sm">
        @if($title)
            <h1 class="text-display-lg">{{ $title }}</h1>
        @endif
        @if($subtitle)
            <p class="text-body-lg text-on-primary-container">{{ $subtitle }}</p>
        @endif
        
        <div class="mt-md">
            {{ $slot }}
        </div>
    </div>
</div>
