@props([
    'label' => 'Label',
    'name',
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'error' => false,
    'helpText' => null,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-on-surface mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <input 
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg border text-on-surface ' . 
            ($error 
                ? 'border-red-500 bg-red-50 dark:bg-red-900/20 focus:ring-red-500' 
                : 'border-outline-variant bg-surface-container-lowest focus:bg-surface-container focus:ring-primary'
            ) . 
            ' focus:outline-none focus:ring-2 transition-all duration-200'
        ]) }}
    >
    
    @if($error)
        <p class="text-xs text-red-600 mt-1">{{ $error }}</p>
    @elseif($helpText)
        <p class="text-xs text-on-surface-variant mt-1">{{ $helpText }}</p>
    @endif
</div>
