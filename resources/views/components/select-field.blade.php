@props([
    'items' => [], // Array of ['value' => '', 'label' => '', 'icon' => null]
    'name',
    'selected' => null,
    'label' => 'Pilih',
    'required' => false,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-on-surface mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <select 
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-200'
        ]) }}
    >
        <option value="">-- {{ $label }} --</option>
        @foreach($items as $item)
            <option value="{{ $item['value'] }}" @selected($selected === $item['value'])>
                @if(isset($item['icon']))
                    {{ $item['icon'] }}
                @endif
                {{ $item['label'] }}
            </option>
        @endforeach
    </select>
</div>
