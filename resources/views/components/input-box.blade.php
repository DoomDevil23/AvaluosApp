<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-white">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" autocomplete="off" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $required ? 'required' : '' }} value={{ $value ?? '' }}>
</div>