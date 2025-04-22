<div>
    <select 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-8 px-2 py-1 text-sm']) }}
    >
        <option value="">{{ $placeholder ?? 'Seleccionar' }}</option>

        {{-- If roles are passed, populate the select --}}
        @if(!empty($options))
            @foreach($options as $option)
                <option value="{{ $option['id'] }}" {{ $idSelected == $option['id'] ? 'selected' : '' }}>
                    {{ $option['name'] }}
                </option>
            @endforeach
        @endif
            
    </select>
</div>