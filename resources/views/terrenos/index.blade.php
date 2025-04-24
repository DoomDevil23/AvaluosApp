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
                            id="fechaInscripcion"
                            name="fechaInscripcion"
                            label="Fecha de Creación"
                            type="date"
                            required="true"
                        />

                        <x-input-box
                            id="tituloFinca"
                            name="tituloFinca"
                            label="Titulo de Finca"
                            type="text"
                            required="true"
                        />

                        <x-input-box
                            id="areaTerreno"
                            name="areaTerreno"
                            label="Area del Terreno"
                            type="text"
                            required="true"
                        />

                        <x-input-box
                            id="valorTerreno"
                            name="valorTerreno"
                            label="Valor del Terrenno"
                            type="text"
                            required="true"
                        />

                        <x-input-box
                            id="valorMejora"
                            name="valorMejora"
                            label="Valor de la Mejora"
                            type="text"
                            required="true"
                        />

                        <x-select
                            id="idTipoMejora"
                            name="idTipoMejora"
                            label="Tipo de Mejora"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="provincia"
                            name="provincia"
                            label="Provincia"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="distrito"
                            name="distrito"
                            label="Distrito"
                            placeholder="Seleccionar"
                        />

                        <x-select
                            id="idCorregimiento"
                            name="idCorregimiento"
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

                        <x-file-input
                            name="planoLote"
                            label="Plano del Lote"
                            :required=false
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
    <form method="GET" action="{{ route('terrenos.index') }}" class="mb-4" id="busquedaForm">
        <div class="buscar-form-element">
            
            <x-input-box-buscar
                id="tituloFinca"
                name="tituloFinca"
                placeholder="Titulo de Finca"
                title="Titulo de Finca"
                type="text"
                value="{{ request('tituloFinca') ?? null }}"
            />

            <x-input-box-buscar
                id="codigoUbicacion"
                name="codigoUbicacion"
                placeholder="Codigo de Ubicación"
                title="Código de Ubicación"
                type="text"
                value="{{ request('codigoUbicacion') ?? null }}"
            />

            <x-input-box-buscar
                id="areaMin"
                name="areaMin"
                placeholder="Área Mínima"
                title="Área Mínima"
                type="text"
                value="{{ request('areaMin') ?? null }}"
            />

            <x-input-box-buscar
                id="areaMax"
                name="areaMax"
                placeholder="Área Máxima"
                title="Área Máxima"
                type="text"
                value="{{ request('areaMax') ?? null }}"
            />

            <x-input-box-buscar
                id="valorTerrenoMin"
                name="valorTerrenoMin"
                placeholder="Valor Terreno Mínimo"
                title="Valor Terreno Mínimo"
                type="text"
                value="{{ request('valorTerrenoMin') ?? null }}"
            />

            <x-input-box-buscar
                id="valorTerrenoMax"
                name="valorTerrenoMax"
                placeholder="Valor Terreno Máximo"
                title="Valor de Terreno Máximo"
                type="text"
                value="{{ request('valorTerrenoMax') ?? null }}"
            />

            <x-input-box-buscar
                id="valorMejoraMin"
                name="valorMejoraMin"
                placeholder="Valor Mejora Mínimo"
                title="Valor de Mejora Mínimo"
                type="text"
                value="{{ request('valorMejoraMin') ?? null }}"
            />

            <x-input-box-buscar
                id="valorMejoraMax"
                name="valorMejoraMax"
                placeholder="Valor Mejora Máximo"
                title="Valor de Mejora Máximo"
                type="text"
                value="{{ request('valorMejoraMax') ?? null }}"
            />

            <x-input-box-buscar
                id="fechaInicio"
                name="fechaInicio"
                placeholder="Fecha Inicio"
                title="Fecha Inicio"
                type="date"
                value="{{ request('fechaInicio') ?? null }}"
            />

            <x-input-box-buscar
                id="fechaFin"
                name="fechaFin"
                placeholder="Fecha Fin"
                title="Fecha Fin"
                type="date"
                value="{{ request('fechaFin') ?? null }}"
            />

            <x-select-buscar
                id="tipoMejora"
                name="idTipoMejora"
                label=""
                placeholder="Tipo Mejora"
                title="Tipo Mejora"
                isSelected="{{ request('idTipoMejora') }}"
            />

            <x-select-buscar
                id="idProvincia"
                name="idProvincia"
                label=""
                placeholder="Provincia"
                title="Provincia"
                isSelected="{{ request('idProvincia') }}"
            />

            <x-select-buscar
                id="idDistrito"
                name="idDistrito"
                label=""
                placeholder="Distrito"
                title="Distrito"
                isSelected="{{ request('idDistrito') }}"
            />

            <x-select-buscar
                id="idCorregimientoBuscar"
                name="idCorregimiento"
                label=""
                placeholder="Corregimiento"
                title="Corregimiento"
                isSelected="{{ request('idCorregimiento') }}"
            />

            <x-select-buscar
                id="idComunidadBuscar"
                name="idComunidadBuscar"
                label=""
                placeholder="Comunidad"
                title="Comunidad"
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
                    <th title="Fecha en que se inscribió en el registo público">F. Inscripci&oacute;n</th>
                    <th title="Título de la finca">T. Finca</th>
                    <th title="Código de ubicación por corregimiento">C&oacute;d. Ubic.</th>
                    <th title="Área del terreno">Área</th>
                    <th title="Valor del terreno">Val. Terreno</th>
                    <th title="Valor de las mejoras/construcciones realizadas">Val. Mejora</th>
                    <th title="Valor del traspaso = valor del terreno + valor de la mejora">Val. Traspaso</th>
                    <th title="Valor del M^2 = valor del terreno / M^2">Val. M<sup>2</sup></th>
                    <th title="Valor total del M^2 = (valor del terreno + valor de la mejora) / M^2">Val. M<sup>2</sup> Total</th>
                    <th title="Tipo de la Mejora">Tipo Mejora</th>
                    <th title="Provincia donde se encuentra el terreno">Provincia</th>
                    <th title="Distrito donde se encuentra el terreno">Distrito</th>
                    <th title="Corregimiento donde se encuentra el terreno">Corregimiento</th>
                    <th title="Comunidad/barrio donde se encuentra el terreno">Comunidad</th>
                    <th title="Ubicación gps del terreno">Zona</th>
                    <th title="Número de lote dentro del barrio/barriada/comunidad">Lote</th>
                    <th title="Plano de la mejora/contrucción realizada dentro del terreno">Plano</th>
                    <th title="Elimina o actualiza el registro. Acceso restringido">Acciones</th>
                </tr>
            </thead>
            <tbody class="rtb-table">
                @forelse($terrenos as $terreno)
                    <tr>
                        <td>{{ date_format($terreno->fechaInscripcion, 'd-m-Y') }}</td>
                        <td>{{ $terreno->tituloFinca }}</td>
                        <td class="text-center align-middle border p-4">
                            <div class="mx-1 my-1">{{ $terreno->comunidad->corregimiento->codigoUbicacion }}</div>
                            @if(in_array(auth()->user()->idRole, [2, 3]))
                                <div class="mx-1 my-1">
                                    <button type="button"
                                        class="btn btn-primary btn-sm editar-btn editar-codigo-ubicacion"
                                        data-open='addCodigoUbicacionModal'
                                        data-id = "{{ $terreno->comunidad->corregimiento->id }}"
                                        data-codigo-ubicacion = "{{ $terreno->comunidad->corregimiento->codigoUbicacion }}">
                                        Actualizar
                                    </button>
                                </div>
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