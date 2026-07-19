@props([
    'type' => 'info', // info, success, warning, error
    'title' => null,
    'dismissible' => false,
])

@php
$typeClasses = match($type) {
    'success' => 'bg-green-50 dark:bg-emerald-950/60 border border-green-200 dark:border-emerald-800/60 border-l-4 border-l-green-500 dark:border-l-emerald-500 text-green-900 dark:text-emerald-200',
    'warning' => 'bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/60 border-l-4 border-l-amber-500 dark:border-l-amber-500 text-amber-900 dark:text-amber-200',
    'error' => 'bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800/60 border-l-4 border-l-red-500 dark:border-l-red-500 text-red-900 dark:text-red-200',
    'info' => 'bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/60 border-l-4 border-l-blue-500 dark:border-l-blue-500 text-blue-900 dark:text-blue-200',
    default => 'bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/60 border-l-4 border-l-blue-500 dark:border-l-blue-500 text-blue-900 dark:text-blue-200',
};

$iconClass = match($type) {
    'success' => 'text-green-500 dark:text-emerald-400',
    'warning' => 'text-amber-500 dark:text-amber-400',
    'error' => 'text-red-500 dark:text-red-400',
    'info' => 'text-blue-500 dark:text-blue-400',
    default => 'text-blue-500 dark:text-blue-400',
};
@endphp

<div {{ $attributes->merge(['class' => "{$typeClasses} p-4 rounded-lg flex items-start gap-3"]) }} role="alert">
    <div class="flex-shrink-0">
        @switch($type)
            @case('success')
                <svg class="h-5 w-5 {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                @break
            @case('warning')
                <svg class="h-5 w-5 {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                @break
            @case('error')
                <svg class="h-5 w-5 {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                @break
            @default
                <svg class="h-5 w-5 {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
        @endswitch
    </div>
    <div class="flex-1">
        @if($title)
            <h3 class="font-semibold">{{ $title }}</h3>
        @endif
        <div class="text-sm">{{ $slot }}</div>
    </div>
    @if($dismissible)
        <button type="button" class="text-current opacity-70 hover:opacity-100 transition-opacity" onclick="this.parentElement.style.display='none'">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>
