{{--@extends('layouts.app')

@section('pageTitle', 'Terrenos')

@section('content')--}}
<x-app-layout>
<div class="container">

    {{-- Mensajes de éxito --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Formulario --}}
    <div class="container mx-auto p-4 max-w-screen-80">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Avaluos') }}
            </h2>
        </x-slot>
        @if(in_array(auth()->user()->idRole, [2, 3]))
            <div class="grid grid-cols-1 gap-4">
                <form id="terrenoForm" action="{{ route('terrenos.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
                    @csrf
                    
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <input type="hidden" name="idTerreno" id="idTerreno">
                    <div class="form-element">
                        
                        <x-input-box
                            name="fechaInscripcion"
                            label="Fecha de Creación"
                            type="date"
                            required="true"
                        />

                        <x-input-box
                            name="tituloFinca"
                            label="Titulo de Finca"
                            type="text"
                            required="true"
                        />

                        <x-input-box
                            name="areaTerreno"
                            label="Area del Terreno"
                            type="number"
                            required="true"
                        />

                        <x-input-box
                            name="valorTerreno"
                            label="Valor del Terrenno"
                            type="number"
                            required="true"
                        />

                        <x-input-box
                            name="valorMejora"
                            label="Valor de la Mejora"
                            type="number"
                            required="true"
                        />

                        <x-select
                            id="tipoMejora"
                            name="idTipoMejora"
                            label="Tipo de Mejora"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="provincia"
                            name=""
                            label="Provincia"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="distrito"
                            name=""
                            label="Distrito"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="idCorregimiento"
                            name=""
                            label="Corregimiento"
                            placeholder="Corregimiento"
                        />

                        <x-select
                            id="comunidad"
                            name="idComunidad"
                            label="Comunidad"
                            placeholder="Seleccionar"
                        />

                        <x-input-box
                            name="zona"
                            label="Zona"
                            type="text"
                            required=""
                        />

                        <x-input-box
                            name="lote"
                            label="Lote"
                            type="text"
                            required=""
                        />

                        <x-input-box
                            name="planoLote"
                            label="Plano del Lote"
                            type="file"
                            required=""
                        />

                        {{-- Buttons --}}
                        <div class="btn-wrapper">                        
                            <x-btn-cancelar
                                id="cancelarEdicionTerreno"
                            />
                            <x-btn-guardar-actualizar />
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <hr>
    {{-- Formulario para buscar --}}
    <h4>Buscar</h4>
    <form method="GET" action="{{ route('terrenos.index') }}" class="mb-4">
        <div class="buscar-form-element">
            
            <x-input-box-buscar
                id="tituloFinca"
                name="tituloFinca"
                placeholder="Titulo de Finca"
                type="text"
                value="{{ request('tituloFinca') ?? null }}"
            />

            <x-input-box-buscar
                id="codigoUbicacion"
                name="codigoUbicacion"
                placeholder="Codigo de Ubicación"
                type="text"
                value="{{ request('codigoUbicacion') ?? null }}"
            />

            <x-input-box-buscar
                id="areaMin"
                name="areaMin"
                placeholder="Área mínima"
                type="number"
                value="{{ request('areaMin') ?? null }}"
            />

            <x-input-box-buscar
                id="areaMax"
                name="areaMax"
                placeholder="Área máxima"
                type="number"
                value="{{ request('areaMax') ?? null }}"
            />

            <x-input-box-buscar
                id="valorTerrenoMin"
                name="valorTerrenoMin"
                placeholder="Valor Terreno Mínimo"
                type="number"
                value="{{ request('valorTerrenoMin') ?? null }}"
            />

            <x-input-box-buscar
                id="valorTerrenoMax"
                name="valorTerrenoMax"
                placeholder="Valor Terreno Máximo"
                type="number"
                value="{{ request('valorTerrenoMax') ?? null }}"
            />

            <x-input-box-buscar
                id="valorMejoraMin"
                name="valorMejoraMin"
                placeholder="Valor Mejora Mínimo"
                type="number"
                value="{{ request('valorMejoraMin') ?? null }}"
            />

            <x-input-box-buscar
                id="valorMejoraMax"
                name="valorMejoraMax"
                placeholder="Valor Mejora Máximo"
                type="number"
                value="{{ request('valorMejoraMax') ?? null }}"
            />

            <x-input-box-buscar
                id="fechaInicio"
                name="fechaInicio"
                placeholder="Fecha Inicio"
                type="date"
                value="{{ request('fechaInicio') ?? null }}"
            />

            <x-input-box-buscar
                id="fechaFin"
                name="fechaFin"
                placeholder="Fecha Fin"
                type="date"
                value="{{ request('fechaFin') ?? null }}"
            />

            <x-select-buscar
                id="idTipoMejora"
                name="idTipoMejora"
                label=""
                placeholder="Tipo Mejora"
                isSelected="{{ request('idTipoMejora') }}"
            />

            <x-select-buscar
                id="idProvincia"
                name="idProvincia"
                label=""
                placeholder="Provincia"
                isSelected="{{ request('idProvincia') }}"
            />

            <x-select-buscar
                id="idDistrito"
                name="idDistrito"
                label=""
                placeholder="Distrito"
                isSelected="{{ request('idDistrito') }}"
            />

            <x-select-buscar
                id="idCorregimientoBuscar"
                name="idCorregimiento"
                label=""
                placeholder="Corregimiento"
                isSelected="{{ request('idCorregimiento') }}"
            />

            <x-select-buscar
                id="idComunidad"
                name="idComunidad"
                label=""
                placeholder="Comunidad"
                isSelected="{{ request('idComunidad') }}"
            />
        </div>
        <x-search-controls 
            clearRoute="{{ route('terrenos.index') }}" 
        />
    </form>

    {{-- Tabla de terrenos --}}
    <div class="table-wrapper">
        <h4>Terrenos Registrados</h4>
        {{ $terrenos->appends(request()->query())->links() }}
        <table class="registers-table" id="registersTable">
            <thead class="rth-table">
                <tr>
                    <th>F. Inscripci&oacute;n</th>
                    <th>T. Finca</th>
                    <th>C&oacute;d. Ubic.</th>
                    <th>Área</th>
                    <th>Val. Terreno</th>
                    <th>Val. Mejora</th>
                    <th>Val. Traspaso</th>
                    <th>Val. M<sup>2</sup></th>
                    <th>Val. M<sup>2</sup> Total</th>
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
            <tbody class="rtb-table">
                @forelse($terrenos as $terreno)
                    <tr>
                        <td>{{ date_format($terreno->fechaInscripcion, 'd-m-Y') }}</td>
                        <td>{{ $terreno->tituloFinca }}</td>
                        <td>
                            {{ $terreno->comunidad->corregimiento->codigoUbicacion }}
                            @if(in_array(auth()->user()->idRole, [2, 3]))
                                </br>
                                <button type="button"
                                    class="btn btn-primary btn-sm editar-btn editar-codigo-ubicacion"
                                    data-open='addCodigoUbicacionModal'
                                    data-id = "{{ $terreno->comunidad->corregimiento->id }}"
                                    data-codigo-ubicacion = "{{ $terreno->comunidad->corregimiento->codigoUbicacion }}">
                                    Actualizar
                                </button>
                            @endif
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
                        @if(in_array(auth()->user()->idRole, [2, 3]))
                            <x-action-cell
                                class="editar-terreno" 
                                :editData="[
                                    'id' => $terreno->id,
                                    'fechaInscripcion' => date_format($terreno->fechaInscripcion, 'Y-m-d'),
                                    'tituloFinca' => $terreno->tituloFinca,
                                    'idComunidad' => $terreno->idComunidad,
                                    'idTipoMejora' => $terreno->idTipoMejora,
                                    'valorTerreno' => $terreno->valorTerreno,
                                    'areaTerreno' => $terreno->areaTerreno,
                                    'valorMejora' => $terreno->valorMejora,
                                    'zona' => $terreno->zona,
                                    'lote' => $terreno->lote,
                                    'planoLote' => $terreno->planoLote
                                ]" 
                                :deleteRoute="route('terrenos.destroy', $terreno->id)" 
                            />
                        @else
                            <td>Sin Permisos</td>
                        @endif
                        
                    </tr>
                @empty
                <x-empty-row colspan="18" message="No hay terrenos registrados." />
                @endforelse
            </tbody>
        </table>
        {{ $terrenos->appends(request()->query())->links() }}
    </div>

    @php
        $comunidadInputs =[
            ['id' => 'corregimiento_id_modal', 'name' => 'corregimiento_id', 'type' => 'hidden', 'label' => '', 'required' => false],
            ['id' => 'comunidad_nombre', 'name' => 'nombre', 'type' => 'text', 'label' => 'Nombre de la comunidad', 'required' => true],
        ];

        $comunidadFooter = [
            ['type' => 'submit', 'label' => 'Guardar', 'classes' => 'btn btn-primary'],
            ['type' => 'button', 'label' => 'Cancelar', 'classes' => 'btn btn-secondary', 'attributes' => 'data-bs-dismiss="modal"'],
        ];

        $terrenoInputs = [
            ['id' => 'corregimiento-id-modal', 'name' => 'corregimiento-id', 'type' => 'hidden', 'label' => '', 'required' => false],
            ['id' => 'codigo_ubicacion', 'name' => 'codigoUbicacion', 'type' => 'text', 'label' => 'Codigo de Ubicación', 'required' => false],
        ];

        $terrenoFooter =[
            ['type' => 'submit', 'label' => 'Actualizar', 'classes' => 'btn btn-primary'],
            ['type' => 'button', 'label' => 'Cancelar', 'classes' => 'btn btn-secondary', 'attributes' => 'data-bs-dismiss="modal"'],
        ];
    @endphp

    <x-my-modal 
        id="addComunidadModal"
        title="Agregar nueva comunidad"
        formId="addComunidadForm"
        :inputs="$comunidadInputs"
        :footerButtons="$comunidadFooter"
    />

    <x-my-modal 
        id="addCodigoUbicacionModal"
        title="Modificar el Código de Ubicación"
        formId="addCodigoUbicacionForm"
        :inputs="$terrenoInputs"
        :footerButtons="$terrenoFooter"
    />

</div>

@vite('resources/js/selects.js')
@vite('resources/js/app.js')
@vite('resources/js/terrenos.js')
@vite('resources/js/table.js')
</x-app-layout>
{{--@endsection--}}