{{-- @extends('layouts.app')

@section('pageTitle', 'Comunidades')

@section('content') --}}
<x-app-layout header="Comunidades - Avaluos App">
    <div class="container">
    
        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Comunidades') }}
            </h2>
        </x-slot>
        {{-- Formulario --}}
        <div class="container mx-auto p-4 max-w-screen-80">
            
            
            {{-- Formulario --}}
            <div class="grid grid-cols-1 gap-4">
                @if(in_array(auth()->user()->idRole, [2, 3]))
                    <form id="comunidadForm" action="{{ route('comunidades.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
                        @csrf
                        
                        <input type="hidden" name="_method" value="POST" id="formMethod">
                        <input type="hidden" name="idComunidad" id="idComunidad">

                        {{-- Adjusted Grid Layout --}}
                        <div class="form-element"> 
                            {{-- Input: Nombre --}}
                            <x-input-box
                                name="name"
                                label="Nombre"
                                type="text"
                                required="true"
                            />

                            {{-- Input: Provincia --}}
                            <x-select 
                                id="provincia" 
                                name="provincia" 
                                label="Provincia"  
                                placeholder="Seleccionar"
                            />

                            {{-- Input: Distrito --}}
                            <x-select
                                id="distrito"
                                name="distrito"
                                label="Distrito"
                                placeholder="Seleccionar"
                            />

                            {{-- Input: Corregimiento --}}
                            <x-select
                                id="idCorregimiento"
                                name="idCorregimiento"
                                label="Corregimiento"
                                placeholder="Seleccionar"
                            />
                        </div>

                        {{-- Buttons --}}
                        <div class="btn-wrapper">
                            <!--<button type="button" class="hidden btn-secondary text-black bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300" id="cancelarEdicionComunidad">Cancelar</button>-->
                            <x-btn-cancelar
                                id="cancelarEdicionComunidad"
                            />
                            <!--<button type="submit" class="btn-primary">Guardar</button>-->
                            <x-btn-guardar-actualizar />
                        </div>
                    </form>
                @endif
            </div>
        </div>
    
        <hr>
        {{-- Formulario para buscar --}}
        <x-search-drop-down />

        <form method="GET" action="{{ route('comunidades.index') }}" class="mb-4 hidden" id="busquedaForm">
            <div class="buscar-form-element">
                <x-input-box-buscar
                    id="nameBuscar"
                    name="name"
                    placeholder="Nombre de la Comunidad"
                    title="Nombre de la Comunidad"
                    type="text"
                    value="{{ request('name') ?? null }}"
                />

                <x-select-buscar
                    id="idProvincia"
                    name="idProvincia"
                    label=""
                    placeholder="Provincia"
                    title="Provincia"
                    idSelected="{{ request('idProvincia') }}"
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
                    isSelected="idCorregimiento"
                />
            </div>
            <x-search-controls 
                clearRoute="{{ route('comunidades.index') }}" 
            />
        </form>
    
        {{-- Tabla de comunidades --}}
        <div class="table-wrapper">
            <h4>Comunidades Registradas</h4>
            <div class="mt-4">
                {{ $comunidades->links() }}
            </div>
            <table class="registers-table" id="registersTable">
                <thead class="rth-table">
                    <tr>
                        <th title="Nombre de la comunidad/barrio/barriada">Nombre</th>
                        <th title="Provincia donde se encuentra la comunidad/barrio/barriada">Provincia</th>
                        <th title="Distrito donde se encuentra la comunidad/barrio/barriada">Distrito</th>
                        <th title="Corregimiento donde se encuentra la comunidad/barrio/barriada">Corregimiento</th>
                        <th title="Actualizar o eliminar la comunidad/barrio/barriada. Restringido">Acciones</th>
                    </tr>
                </thead>
                <tbody class="rtb-table">
                    @forelse($comunidades as $comunidad)
                        <tr>
                            <td>{{ $comunidad->name }}</td>
                            <td>{{ $comunidad->corregimiento->distrito->provincia->name ?? 'N/A' }}</td>
                            <td>{{ $comunidad->corregimiento->distrito->name ?? 'N/A' }}</td>
                            <td>{{ $comunidad->corregimiento->name ?? 'N/A' }}</td>
                            @if(in_array(auth()->user()->idRole, [2, 3]))
                                <x-action-cell
                                    class="editar-comunidad" 
                                    :editData="['id' => $comunidad->id, 'name' => $comunidad->name, 'idCorregimiento' => $comunidad->idCorregimiento]" 
                                    :deleteRoute="route('comunidades.destroy', $comunidad->id)" 
                                />
                            @else
                                <td>Sin Permisos</td>
                            @endif
                        </tr>
                    @empty
                        <x-empty-row colspan="5" message="No hay comunidades registradas." />
                    @endforelse
                </tbody>
            </table>
            {{ $comunidades->links() }}
        </div>
    </div>
    @vite('resources/js/app.js')
    @vite('resources/js/selects.js')
    @vite('resources/js/comunidades.js')
    @vite('resources/js/table.js')
    @vite('resources/js/searchDropDown.js')
</x-app-layout>
{{--@endsection--}}