@extends('layouts.app')

@section('pageTitle', 'Terrenos')

@section('content')
<div class="container">
    <h2 class="mb-4">Registro de Terrenos</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario --}}
    <form id="terrenoForm" action="{{ route('terrenos.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        
        <input type="hidden" name="_method" value="POST" id="formMethod">
        <input type="hidden" name="idTerreno" id="idTerreno">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="fechaInscripcion" class="form-label">Fecha de creación</label>
                <input type="date" name="fechaInscripcion" id="fechaInscripcion" class="form-control" value="{{ old('fechaInscripcion') }}">
            </div>

            <div class="col-md-6">
                <label for="tituloFinca" class="form-label">Título de Finca</label>
                <input type="text" name="tituloFinca" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label for="areaTerreno" class="form-label">Área del Terreno</label>
                <input type="number" step="0.01" name="areaTerreno" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label for="valorTerreno" class="form-label">Valor del Terreno</label>
                <input type="number" step="0.01" name="valorTerreno" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label for="valorMejora" class="form-label">Valor de la Mejora</label>
                <input type="number" step="0.01" name="valorMejora" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label for="idTipoMejora" class="form-label">Tipo de Mejora</label>
                <select name="idTipoMejora" class="form-select" required>
                    <option value="">Seleccionar</option>
                    @foreach($tiposMejora as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach
                </select>
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
                <select id="idCorregimiento" class="form-select">
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="idComunidad" class="form-label">Comunidad</label>
                <select name="idComunidad" id="comunidad" class="form-select" required>
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <!--HERE-->

            <div class="col-md-3">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" name="zona" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="lote" class="form-label">Lote</label>
                <input type="text" name="lote" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="planoLote" class="form-label">Plano del Lote (PDF/JPG/PNG)</label>
                <input type="file" name="planoLote" class="form-control">
            </div>

            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-secondary" id="cancelarEdicionTerreno" style="display:none;">Cancelar</button>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Guardar Terreno</button>
            </div>
        </div>
    </form>

    {{-- Formulario para buscar --}}
    <form method="GET" action="{{ route('terrenos.index') }}" class="mb-4">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <input type="text" name="tituloFinca" placeholder="Título de Finca" value="{{ request('tituloFinca') }}">
            <input type="text" name="codigoUbicacion" placeholder="Código de Ubicación" value="{{ request('codigoUbicacion') }}">

            <input type="number" step="0.01" name="areaMin" placeholder="Área mínima" value="{{ request('areaMin') }}">
            <input type="number" step="0.01" name="areaMax" placeholder="Área máxima" value="{{ request('areaMax') }}">

            <input type="number" step="0.01" name="valorTerrenoMin" placeholder="Valor Terreno mínimo" value="{{ request('valorTerrenoMin') }}">
            <input type="number" step="0.01" name="valorTerrenoMax" placeholder="Valor Terreno máximo" value="{{ request('valorTerrenoMax') }}">

            <input type="number" step="0.01" name="valorMejoraMin" placeholder="Valor Mejora mínimo" value="{{ request('valorMejoraMin') }}">
            <input type="number" step="0.01" name="valorMejoraMax" placeholder="Valor Mejora máximo" value="{{ request('valorMejoraMax') }}">

            <input type="date" name="fechaInicio" value="{{ request('fechaInicio') }}">
            <input type="date" name="fechaFin" value="{{ request('fechaFin') }}">

            <select name="idTipoMejora">
                <option value="">-- Tipo de Mejora --</option>
                @foreach($tiposMejora as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach
            </select>

            <select name="idProvincia" id="idProvincia">
                <option value="">-- Provincia --</option>
            </select>

            <select name="idDistrito" id="idDistrito">
                <option value="">-- Distrito --</option>
            </select>

            <select name="idCorregimiento" id="idCorregimientoBuscar">
                <option value="">-- Corregimiento --</option>
            </select>

            <select name="idComunidad" id="idComunidad">
                <option value="">-- Comunidad --</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('terrenos.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    {{-- Tabla de terrenos --}}
    <h4>Terrenos Registrados</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Fecha de Inscripci&oacute;n</th>
                <th>Título Finca</th>
                <th>C&oacute;digo de Ubicaci&oacute;n</th>
                <th>Área</th>
                <th>Valor Terreno</th>
                <th>Valor Mejora</th>
                <th>Valor Traspaso</th>
                <th>Valor de M<sup>2</sup></th>
                <th>Valor de M<sup>2</sup> de Mejoras + Terreno</th>
                <th>Tipo Mejora</th>
                <th>Provincia</th>
                <th>Distrito</th>
                <th>Corregimiento</th>
                <th>Comunidad</th>
                <th>Zona</th>
                <th>Lote</th>
                <th>Plano</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terrenos as $terreno)
                <tr>
                    <td>{{ date_format($terreno->fechaInscripcion, 'd-m-Y') }}</td>
                    <td>{{ $terreno->tituloFinca }}</td>
                    <td>
                        {{ $terreno->comunidad->corregimiento->codigoUbicacion }}
                        </br>
                        <button type="button"
                            class="btn btn-primary btn-sm editar-btn editar-codigo-ubicacion"
                            dataId = "{{ $terreno->comunidad->corregimiento->id }}"
                            dataCodigoUbicacion = "{{ $terreno->comunidad->corregimiento->codigoUbicacion }}">
                            Actualizar
                        </button>
                    </td>
                    <td>{{ $terreno->areaTerreno }} M<sup>2</sup></td>
                    <td>${{ number_format($terreno->valorTerreno,2) }}</td>
                    <td>${{ number_format($terreno->valorMejora, 2) }}</td>
                    <td>${{ number_format($terreno->valorTerreno+$terreno->valorMejora, 2) }}</td>
                    <td>${{ number_format($terreno->valorTerreno/$terreno->areaTerreno, 2) }}</td>
                    <td>${{ number_format(($terreno->valorTerreno + $terreno->valorMejora)/$terreno->areaTerreno, 2) }}</td>
                    <td>{{ $terreno->TipoMejora->name ?? 'N/A' }}</td>
                    <td>{{ $terreno->comunidad->corregimiento->distrito->provincia->name ?? 'N/A' }}</td>
                    <td>{{ $terreno->comunidad->corregimiento->distrito->name ?? 'N/A' }}</td>
                    <td>{{ $terreno->comunidad->corregimiento->name ?? 'N/A' }}</td>
                    <td>{{ $terreno->comunidad->name ?? 'N/A' }}</td>
                    <td>
                        @if($terreno->zona)
                            <a href="{{ $terreno->zona}}" class="btn btn-sm btn-outline-primary" target="blank">Ver Mapa</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $terreno->lote ?? 'N/A' }}</td>
                    <td>
                        @if($terreno->planoLote)
                            <a href="{{ asset('storage/' . $terreno->planoLote) }}" class="btn btn-sm btn-outline-primary" target="_blank">Ver plano</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <button type="button" 
                                class="btn btn-primary btn-sm editar-btn editar-terreno" 
                                dataId="{{ $terreno->id }}"
                                dataFechaInscripcion="{{ date_format($terreno->fechaInscripcion, 'Y-m-d') }}"
                                dataTituloFinca="{{ $terreno->tituloFinca }}"
                                dataIdComunidad="{{ $terreno->idComunidad }}"
                                dataIdTipoMejora="{{ $terreno->idTipoMejora }}"
                                dataValorTerreno="{{ $terreno->valorTerreno }}"
                                dataAreaTerreno="{{ $terreno->areaTerreno }}"
                                dataValorMejora="{{ $terreno->valorMejora }}"
                                dataZona="{{ $terreno->zona }}"
                                dataLote="{{ $terreno->lote }}"
                                dataPlanoLote="{{ $terreno->planoLote }}">
                            Editar
                        </button>
                        <form action="{{ route('terrenos.destroy', $terreno) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11">No hay terrenos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="modal fade" id="addComunidadModal" tabindex="-1" aria-labelledby="addComunidadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addComunidadForm">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addComunidadModalLabel">Agregar nueva comunidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" id="corregimiento_id_modal" name="corregimiento_id">
                <div class="mb-3">
                    <label for="comunidad_nombre" class="form-label">Nombre de la comunidad</label>
                    <input type="text" class="form-control" id="comunidad_nombre" name="nombre" required>
                </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addCodigoUbicacionModal" tabindex="-1" aria-labellledby="addCodigoUbicacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addCodigoUbicacionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCodigoUbicacionLabel">Modificar el C&oacute;digo de Ubicaci&oacute;n</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="corregimiento-id-modal" name="corregimiento-id">
                        <div class="mb-3">
                            <label for="codigo_ubicacion" class="form-label">C&oacute;digo de Ubicaci&oacute;n</label>
                            <input type="text" class="form-control" id="codigo_ubicacion" name="codigoUbicacion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@vite('resources/js/app.js')
@vite('resources/js/terrenos.js')
@endsection