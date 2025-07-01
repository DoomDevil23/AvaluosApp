{{-- @extends('layouts.app')

@section('pageTitle', 'Comunidades')

@section('content') --}}
<x-app-layout header="Usuarios - Avaluos App">
    <div class="container">
    
        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Usuarios') }}
            </h2>
        </x-slot>
        {{-- Formulario --}}
        <div class="container mx-auto p-4 max-w-screen-80">
            
        {{-- Formulario para buscar --}}
        <x-search-drop-down />

        <form method="GET" action="{{ route('users.index') }}" class="mb-4 hidden" id="busquedaForm">
            <div class="buscar-form-element">
                <x-input-box-buscar
                    id="nameBuscar"
                    name="name"
                    placeholder="Nombre del Usuario"
                    title="Nombre del Usuario"
                    type="text"
                    value="{{ request('name') ?? null }}"
                />

                <x-input-box-buscar
                    id="emailBuscar"
                    name="email"
                    placeholder="Email del Usuario"
                    title="Email del Usuario"
                    type="text"
                    value="{{ request('email') ?? null }}"
                />

                <x-select-buscar
                    id="idRoleBuscar"
                    name="idRole"
                    label=""
                    placeholder="Rol"
                    title="Rol del Usuario"
                    idSelected="{{ request('idRole') }}"
                    :options="$roles"
                />
    
            </div>
            <x-search-controls 
                clearRoute="{{ route('users.index') }}" 
            />
        </form>
    
        {{-- Tabla de usuarios --}}
        <div class="table-wrapper">
            <h4>Usuarios Registradas</h4>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
            <table class="registers-table" id="registersTable">
                <thead class="rth-table">
                    <tr>
                        <th>Nombre</th>
                        <th>E-Mail</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="rtb-table">
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email ?? 'N/A' }}</td>
                            <td class="content-center flex justify-center items-center">
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="idRole" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black h6 text-xs my-5">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $role->id == $user->idRole ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary ml-2">Actualizar</button>
                                </form>                            
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 btn-sm mb-5">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <x-empty-row colspan="5" message="No hay comunidades registradas." />
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
    @vite('resources/js/app.js')
    @vite('resources/js/selects.js')
    @vite('resources/js/table.js')
    @vite('resources/js/searchDropDown.js')
</x-app-layout>
{{--@endsection--}}