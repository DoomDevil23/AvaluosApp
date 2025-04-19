//UPDATE
document.querySelectorAll('.editar-terreno').forEach(button => {
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
                        const corregimientoSelect = document.getElementById('idCorregimiento');
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
                        comunidadSelect.innerHTML += `<option value="__add_new__">➕ Nueva comunidad</option>`;
                    });
            })
            .catch(error => {
                console.error('Error cargando comunidad y ubicación:', error);
            });

        // Opcional: desplazarse al formulario
        window.scrollTo({ top: 0, behavior: 'smooth' });

        const form = document.getElementById('terrenoForm');
        form.action = '/terrenos/'+document.getElementById('idTerreno').value;
        document.getElementById('formMethod').value = 'PUT';

        document.querySelector('#terrenoForm button[type="submit"]').textContent = 'Actualizar Terreno';
        document.getElementById('cancelarEdicionTerreno').style.display = 'inline-block';
    });
});

document.getElementById('cancelarEdicionTerreno').addEventListener('click', function () {
    const form = document.getElementById('terrenoForm');
    form.reset();
    form.action = "{{ route('terrenos.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('idTerreno').value = '';
    this.style.display = 'none';
    document.querySelector('#terrenoForm button[type="submit"]').textContent = 'Guardar Terreno';
    document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
    document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
    document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
});

//ADD NEW COMUNIDAD
document.getElementById('addComunidadForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let corregimiento_id = document.getElementById('corregimiento_id_modal').value;
    let nombre = document.getElementById('comunidad_nombre').value;

    fetch('/comunidades', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest' // ← This tells Laravel it’s an AJAX request
        },
        body: JSON.stringify({ idCorregimiento: corregimiento_id, name: nombre })
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.id) {
            let comunidadSelect = document.getElementById('comunidad');
            comunidadSelect.innerHTML += `<option value="${data.id}" selected>${data.name}</option>`;
            bootstrap.Modal.getInstance(document.getElementById('addComunidadModal')).hide();
        } else {
            alert("Error al guardar comunidad.");
        }
    })
    .then(async res => {
        if (!res.ok) {
            const errorData = await res.json();
            console.error("Error del servidor:", errorData);
            alert("Error al guardar comunidad. Verifica los campos.");
            return;
        }

        return res.json();
    })
    .then(data => {
        if (data && data.id) {
            let comunidadSelect = document.getElementById('comunidad');
            comunidadSelect.innerHTML += `<option value="${data.id}" selected>${data.name}</option>`;
            bootstrap.Modal.getInstance(document.getElementById('addComunidadModal')).hide();
        }
    })
    .catch(err => console.error(err));
});

//UPDATE CODIGO UBICACION
document.getElementById('addCodigoUbicacionForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let corregimiento_id = document.getElementById('corregimiento-id-modal').value;
    let codigo_ubicacion = document.getElementById('codigo_ubicacion').value;

    fetch(`/corregimientos/${corregimiento_id}/codigo-ubicacion`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest' // ← This tells Laravel it’s an AJAX request
        },
        body: JSON.stringify({ codigoUbicacion: codigo_ubicacion })
    })
    .then(response => {
        if(!response.ok) throw new Error('Error al actualizar');
        return response.json();
    })
    .then(data =>{
        alert('Código de ubicación actualizado correctamente');
        document.getElementById('addCodigoUbicacionForm').reset();
        let modal = bootstrap.Modal.getInstance(document.getElementById('addCodigoUbicacionModal'));
        modal.hide();

        window.location.reload();
    })
    .catch(error => {
        console.error('Error: ', error);
        alert('Hubo un error al actualizar');
    });
});

//CARGANDO CAMPOS EN MODAL PARA ACTUALIZAR EL CODIGO DE UBICACION
document.querySelectorAll('.editar-codigo-ubicacion').forEach(button => {
    button.addEventListener('click', function(){
        const id = this.getAttribute('dataId');
        document.getElementById('corregimiento-id-modal').value = id;
        const codigoUbicacion = this.getAttribute('dataCodigoUbicacion');
        if(codigoUbicacion){
            document.getElementById('codigo_ubicacion').value = codigoUbicacion;
        }

        let modal = new bootstrap.Modal(document.getElementById('addCodigoUbicacionModal'));
        modal.show();
    });
});