@extends('layouts.app')

@section('pageTitle', 'Comunidades')

@section('content')
<div class="container">
    <h2 class="mb-4">Registro de Comunidades</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario --}}
    <form id="comunidadForm" action="{{ route('comunidades.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        
        <input type="hidden" name="_method" value="POST" id="formMethod">
        <input type="hidden" name="idComunidad" id="idComunidad">
        <div class="row g-3">

            <div class="col-md-6">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!--HERE-->
            <div class="col-md-3">
                <label for="provincia" class="form-label">Provincia</label>
                <select id="provincia" class="form-select">
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="distrito" class="form-label">Distrito</label>
                <select id="distrito" class="form-select">
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="idCorregimiento" class="form-label">Corregimiento</label>
                <select id="idCorregimiento" name="idCorregimiento" class="form-select">
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <!--HERE-->

            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-secondary" id="cancelarEdicionComunidad" style="display:none;">Cancelar</button>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Guardar Comunidad</button>
            </div>
        </div>
    </form>

    {{-- Formulario para buscar --}}
    <form method="GET" action="{{ route('comunidades.index') }}" class="mb-4">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <input type="text" name="name" placeholder="Nombre de la Comunidad" value="{{ request('nombreComunidad') }}">

            <select name="idProvincia" id="idProvincia">
                <option value="">-- Provincia --</option>
            </select>

            <select name="idDistrito" id="idDistrito">
                <option value="">-- Distrito --</option>
            </select>

            <select name="idCorregimiento" id="idCorregimientoBuscar">
                <option value="">-- Corregimiento --</option>
            </select>

        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('comunidades.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    {{-- Tabla de comunidades --}}
    <h4>Comunidades Registradas</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Provincia</th>
                <th>Distrito</th>
                <th>Corregimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comunidades as $comunidad)
                <tr>
                    <td>{{ $comunidad->name }}</td>
                    <td>{{ $comunidad->corregimiento->distrito->provincia->name ?? 'N/A' }}</td>
                    <td>{{ $comunidad->corregimiento->distrito->name ?? 'N/A' }}</td>
                    <td>{{ $comunidad->corregimiento->name ?? 'N/A' }}</td>
                    <td>
                        <button type="button" 
                                class="btn btn-primary btn-sm editar-btn editar-comunidad" 
                                dataId="{{ $comunidad->id }}"
                                dataNombreComunidad="{{ $comunidad->name }}"
                                dataIdCorregimiento="{{ $comunidad->idCorregimiento }}">
                            Editar
                        </button>
                        <form action="{{ route('comunidades.destroy', $comunidad->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                            
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11">No hay comunidades registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@vite('resources/js/app.js')
@vite('resources/js/comunidades.js')
@endsection