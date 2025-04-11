@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registro de Terrenos</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('terrenos.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        <input type="hidden" name="id" id="idTerreno">
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
                    <!--@foreach($provincias as $provincia)
                        <option value="{{ $provincia->id }}">{{ $provincia->name }}</option>
                    @endforeach-->
                </select>
            </div>

            <div class="col-md-3">
                <label for="distrito" class="form-label">Distrito</label>
                <select id="distrito" class="form-select">
                    <option value="">Seleccionar</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="corregimiento" class="form-label">Corregimiento</label>
                <select id="corregimiento" class="form-select">
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
                <button type="submit" class="btn btn-primary">Guardar Terreno</button>
            </div>
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
                    <td>{{ $terreno->comunidad->corregimiento->codigoUbicacion }}</td>
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
                    <td>{{ $terreno->Comunidad->name ?? 'N/A' }}</td>
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
                                class="btn btn-primary btn-sm editar-btn" 
                                dataId="{{ $terreno->id }}"
                                dataFechaInscripcion="{{ $terreno->fechaInscripcion }}"
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
</div>

<script>
    /*document.getElementById('provincia').addEventListener('change', function () {
        let provinciaId = this.value;
        fetch(`/distritos/${provinciaId}`)
            .then(res => res.json())
            .then(data => {
                let distritoSelect = document.getElementById('distrito');
                distritoSelect.innerHTML = '<option value="">Seleccionar</option>';
                data.forEach(d => {
                    distritoSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                });

                document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
                document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
            });
    });*/

    document.getElementById('distrito').addEventListener('change', function () {
        let distritoId = this.value;
        fetch(`/corregimientos/${distritoId}`)
            .then(res => res.json())
            .then(data => {
                let corregimientoSelect = document.getElementById('corregimiento');
                corregimientoSelect.innerHTML = '<option value="">Seleccionar</option>';
                data.forEach(c => {
                    corregimientoSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                });

                document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
            });
    });

    document.getElementById('corregimiento').addEventListener('change', function () {
        let corregimientoId = this.value;
        fetch(`/comunidades/${corregimientoId}`)
            .then(res => res.json())
            .then(data => {
                let comunidadSelect = document.getElementById('comunidad');
                comunidadSelect.innerHTML = '<option value="">Seleccionar</option>';
                data.forEach(c => {
                    comunidadSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                });
            });
    });

    document.addEventListener('DOMContentLoaded', function () {
    fetch('/provincias')
        .then(res => res.json())
        .then(data => {
            let provinciaSelect = document.getElementById('provincia');
            data.forEach(p => {
                provinciaSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        });
    });

    document.getElementById('provincia').addEventListener('change', function () {
        let provinciaId = this.value;  // Get selected provincia ID
        if (provinciaId) {
            // Fetch distritos for the selected provincia
            fetch(`/distritos/${provinciaId}`)
                .then(res => res.json())
                .then(data => {
                    let distritoSelect = document.getElementById('distrito');
                    // Clear previous options and add the default one
                    distritoSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(d => {
                        // Append each distrito as an option
                        distritoSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                    });

                    // Clear the corregimiento and comunidad selects
                    document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
                    document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
                })
                .catch(error => console.error('Error fetching distritos:', error));
        } else {
            // If no provincia is selected, clear the distrito select options
            document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
        }
    });

    //HERE
    document.getElementById('provincia').addEventListener('change', function () {
        let provinciaId = this.value;  // Get selected provincia ID
        if (provinciaId) {
            // Fetch distritos for the selected provincia
            fetch(`/distritos/${provinciaId}`)
                .then(res => res.json())
                .then(data => {
                    let distritoSelect = document.getElementById('distrito');
                    // Clear previous options and add the default one
                    distritoSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(d => {
                        // Append each distrito as an option
                        distritoSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                    });

                    // Clear the corregimiento and comunidad selects
                    document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
                    document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
                })
                .catch(error => console.error('Error fetching distritos:', error));
        } else {
            // If no provincia is selected, clear the distrito, corregimiento, and comunidad select options
            document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
            document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
            document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });

    document.getElementById('distrito').addEventListener('change', function () {
        let distritoId = this.value;  // Get selected distrito ID
        if (distritoId) {
            // Fetch corregimientos for the selected distrito
            fetch(`/corregimientos/${distritoId}`)
                .then(res => res.json())
                .then(data => {
                    let corregimientoSelect = document.getElementById('corregimiento');
                    // Clear previous options and add the default one
                    corregimientoSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(c => {
                        // Append each corregimiento as an option
                        corregimientoSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                    });

                    // Clear the comunidad select
                    document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
                })
                .catch(error => console.error('Error fetching corregimientos:', error));
        } else {
            // If no distrito is selected, clear the corregimiento and comunidad select options
            document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
            document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });

    document.getElementById('corregimiento').addEventListener('change', function () {
        let corregimientoId = this.value;  // Get selected corregimiento ID
        if (corregimientoId) {
            // Fetch comunidades for the selected corregimiento
            fetch(`/comunidades/${corregimientoId}`)
                .then(res => res.json())
                .then(data => {
                    let comunidadSelect = document.getElementById('comunidad');
                    // Clear previous options and add the default one
                    comunidadSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(com => {
                        // Append each comunidad as an option
                        comunidadSelect.innerHTML += `<option value="${com.id}">${com.name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching comunidades:', error));
        } else {
            // If no corregimiento is selected, clear the comunidad select options
            document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });    

    //UPDATE
    document.querySelectorAll('.editar-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Get data from button attributes
            const id = this.getAttribute('dataId');
            const fecha = this.getAttribute('dataFechaInscripcion');
            const titulo = this.getAttribute('dataTituloFinca');
            const idComunidad = this.getAttribute('dataIdComunidad');
            const idTipoMejora = this.getAttribute('dataIdTipoMejora');
            const valorTerreno = this.getAttribute('dataValorTerreno');
            const areaTerreno = this.getAttribute('dataAreaTerreno');
            const valorMejora = this.getAttribute('dataValorMejora');
            const zona = this.getAttribute('dataZona');
            const lote = this.getAttribute('dataLote');
            const planoLote = this.getAttribute('dataPlanoLote');

            // Set form values
            document.getElementById('idTerreno').value = id;
            document.getElementById('fechaInscripcion').value = fecha;
            document.querySelector('[name="tituloFinca"]').value = titulo;
            document.querySelector('[name="valorTerreno"]').value = valorTerreno;
            document.querySelector('[name="areaTerreno"]').value = areaTerreno;
            document.querySelector('[name="valorMejora"]').value = valorMejora;
            document.querySelector('[name="zona"]').value = zona;
            document.querySelector('[name="lote"]').value = lote;

            // Selects: Comunidad y TipoMejora
            document.querySelector('[name="idTipoMejora"]').value = idTipoMejora;

            // Comunidad requires fetching provincia → distrito → corregimiento
            // We'll handle this next 👇

            // Simulate selecting Comunidad (load chain if necessary)
            fetch(`/comunidad-info/${idComunidad}`)
                .then(res => res.json())
                .then(data => {
                    const { provincia_id, distrito_id, corregimiento_id, comunidad_id } = data;

                    // Set Provincia
                    document.getElementById('provincia').value = provincia_id;

                    // Load distritos
                    return fetch(`/distritos/${provincia_id}`)
                        .then(res => res.json())
                        .then(distritos => {
                            const distritoSelect = document.getElementById('distrito');
                            distritoSelect.innerHTML = '<option value="">Seleccionar</option>';
                            distritos.forEach(d => {
                                distritoSelect.innerHTML += `<option value="${d.id}" ${d.id == distrito_id ? 'selected' : ''}>${d.name}</option>`;
                            });

                            // Load corregimientos
                            return fetch(`/corregimientos/${distrito_id}`);
                        })
                        .then(res => res.json())
                        .then(corregimientos => {
                            const corregimientoSelect = document.getElementById('corregimiento');
                            corregimientoSelect.innerHTML = '<option value="">Seleccionar</option>';
                            corregimientos.forEach(c => {
                                corregimientoSelect.innerHTML += `<option value="${c.id}" ${c.id == corregimiento_id ? 'selected' : ''}>${c.name}</option>`;
                            });

                            // Load comunidades
                            return fetch(`/comunidades/${corregimiento_id}`);
                        })
                        .then(res => res.json())
                        .then(comunidades => {
                            const comunidadSelect = document.getElementById('comunidad');
                            comunidadSelect.innerHTML = '<option value="">Seleccionar</option>';
                            comunidades.forEach(c => {
                                comunidadSelect.innerHTML += `<option value="${c.id}" ${c.id == comunidad_id ? 'selected' : ''}>${c.name}</option>`;
                            });
                        });
                })
                .catch(error => {
                    console.error('Error cargando comunidad y ubicación:', error);
                });

            // Opcional: desplazarse al formulario
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
@endsection