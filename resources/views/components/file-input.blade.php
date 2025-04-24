<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-white">{{ $label }}</label>
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        class="mt-1 block w-full text-sm text-white file:mr-4 file:py-2 file:px-4
               file:rounded-md file:border-0 file:text-sm file:font-semibold
               file:bg-indigo-600 file:text-white hover:file:bg-indigo-700
               bg-darkblue"
        {{ $required ? 'required' : '' }}
    >
</div>
