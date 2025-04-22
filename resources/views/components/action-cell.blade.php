<td class="td-acciones">
    {{-- Edit Button --}}
    @if ($editData)
        <button type="button" 
                class="btn-primary btn-sm editar-btn {{ $class }}" 
                @foreach ($editData as $key => $value)
                    data-{{ $key }}="{{ $value }}"
                @endforeach>
            Editar
        </button>
    @endif

    {{-- Delete Form --}}
    @if ($deleteRoute)
        <form action="{{ $deleteRoute }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
            @csrf
            @method('DELETE')
            <button class="btn-danger bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 btn-sm">Eliminar</button>
        </form>
    @endif
</td>