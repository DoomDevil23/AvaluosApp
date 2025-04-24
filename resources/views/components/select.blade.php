<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-white">{{ $label }}</label>
    <select required 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}
    >
        <option value="">{{ $placeholder ?? 'Seleccionar' }}</option>
            
        {{-- If roles are passed, populate the select --}}
        @if(!empty($options))
            @foreach($options as $option)
                <option value="{{ $option['id'] }}" >
                    {{ $option['name'] }}
                </option>
            @endforeach
        @endif
        
    </select>
</div>