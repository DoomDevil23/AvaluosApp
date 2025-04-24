//UPDATE
document.querySelectorAll('.editar-terreno').forEach(button => {
    button.addEventListener('click', function () {
        // Get data from button attributes
        const id = this.getAttribute('data-id');
        const fecha = this.getAttribute('data-fechaInscripcion');
        const titulo = this.getAttribute('data-tituloFinca');
        const idComunidad = this.getAttribute('data-idComunidad');
        const idTipoMejora = this.getAttribute('data-idTipoMejora');
        const valorTerreno = this.getAttribute('data-valorTerreno');
        const areaTerreno = this.getAttribute('data-areaTerreno');
        const valorMejora = this.getAttribute('data-valorMejora');
        const zona = this.getAttribute('data-zona');
        const lote = this.getAttribute('data-lote');
        const planoLote = this.getAttribute('data-planoLote');
        
        // Set form values
        document.getElementById('idTerreno').value = id;
        //document.getElementById('fechaInscripcion').value = fecha;
        document.querySelector('[name="fechaInscripcion"]').value = fecha;
        document.querySelector('[name="tituloFinca"]').value = titulo;
        document.querySelector('[name="valorTerreno"]').value = valorTerreno;
        document.querySelector('[name="areaTerreno"]').value = areaTerreno;
        document.querySelector('[name="valorMejora"]').value = valorMejora;
        document.querySelector('[name="zona"]').value = zona;
        document.querySelector('[name="lote"]').value = lote;
        //document.querySelector('[name="planoLote"]').value = planoLote;

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
                        const comunidadSelect = document.getElementById('idComunidad');
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

        document.querySelector('#terrenoForm button[type="submit"]').textContent = 'Actualizar';
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
    document.getElementById('idCorregimiento').innerHTML = '<option value="">Seleccionar</option>';
    document.getElementById('idComunidad').innerHTML = '<option value="">Seleccionar</option>';
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
            'X-Requested-With': 'XMLHttpRequest' // Helps Laravel recognize it's an AJAX request
        },
        body: JSON.stringify({ idCorregimiento: corregimiento_id, name: nombre })
    })
    .then(response => response.json().then(data => {
        if (!response.ok) {
            throw new Error(data.message || 'Error al guardar comunidad.');
        }
        return data;
    }))
    .then(data => {
        if (data && data.id) {
            let comunidadSelect = document.getElementById('idComunidad');
            comunidadSelect.innerHTML += `<option value="${data.id}" selected>${data.name}</option>`;

            // Manually close modal using updated logic
            const modal = document.getElementById('addComunidadModal');
            modal.style.display = 'none'; // Hide modal
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'opacity-100');

            alert("Comunidad guardada correctamente.");
        } else {
            alert("Error al guardar comunidad.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Hubo un error al guardar comunidad.");
    });
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
            'X-Requested-With': 'XMLHttpRequest' // Helps Laravel recognize the request as AJAX
        },
        body: JSON.stringify({ codigoUbicacion: codigo_ubicacion })
    })
    .then(response => {
        return response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.message || 'Error al actualizar');
            }
            return data; // Only return data if the response was OK
        });
    })
    .then(data => {
        alert('Código de ubicación actualizado correctamente');
        document.getElementById('addCodigoUbicacionForm').reset();

        // Hide modal correctly (ensure it's using Tailwind styles or direct JavaScript)
        const modal = document.getElementById('addCodigoUbicacionModal');
        modal.style.display = 'none'; // Ensure modal hides
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-100');

        // Refresh table dynamically without reloading the page
        //actualizarTabla(corregimiento_id, codigo_ubicacion);
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`Hubo un error al actualizar: ${error.message}`);
    });
});

//CHEKING IF THERE'S A QUERY IN LINK TO SET THE SELECTS
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    
    // Check if there are any query parameters before proceeding
    if (!params.toString()) {
        return; // Exit script if no filters are present
    }

    // Retrieve selected values if they exist
    const selectedProvincia = params.get('idProvincia');
    const selectedDistrito = params.get('idDistrito');
    const selectedCorregimiento = params.get('idCorregimiento');
    const selectedComunidad = params.get('idComunidadBuscar');

    // Populate the Provincia select
    fetch('/provincias')
        .then(res => res.json())
        .then(provincias => {
            const provinciaSelect = document.getElementById('idProvincia');
            provinciaSelect.innerHTML = '<option value="">-- Provincia --</option>';

            provincias.forEach(provincia => {
                provinciaSelect.innerHTML += `
                    <option value="${provincia.id}" ${provincia.id == selectedProvincia ? 'selected' : ''}>
                        ${provincia.name}
                    </option>`;
            });

            // Load distritos if Provincia is pre-selected
            if (selectedProvincia) {
                loadDistritos(selectedProvincia);
            }
        });

    function loadDistritos(provinciaId) {
        fetch(`/distritos/${provinciaId}`)
            .then(res => res.json())
            .then(distritos => {
                const distritoSelect = document.getElementById('idDistrito');
                distritoSelect.innerHTML = '<option value="">-- Distrito --</option>';

                distritos.forEach(distrito => {
                    distritoSelect.innerHTML += `
                        <option value="${distrito.id}" ${distrito.id == selectedDistrito ? 'selected' : ''}>
                            ${distrito.name}
                        </option>`;
                });

                // Load corregimientos if Distrito is pre-selected
                if (selectedDistrito) {
                    loadCorregimientos(selectedDistrito);
                }
            });
    }

    function loadCorregimientos(distritoId) {
        fetch(`/corregimientos/${distritoId}`)
            .then(res => res.json())
            .then(corregimientos => {
                const corregimientoSelect = document.getElementById('idCorregimientoBuscar');
                corregimientoSelect.innerHTML = '<option value="">-- Corregimiento --</option>';

                corregimientos.forEach(corregimiento => {
                    corregimientoSelect.innerHTML += `
                        <option value="${corregimiento.id}" ${corregimiento.id == selectedCorregimiento ? 'selected' : ''}>
                            ${corregimiento.name}
                        </option>`;
                });
            });
    }

    function loadComunidades(corregimientoId){
        fetch(`/comunidades/${corregimientoId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // This tells Laravel it's an AJAX request
            }
        })
            .then(res => res.json())
            .then(comunidades =>{
                const comunidadSelect = document.getElementById('idComunidadBuscar');
                comunidadSelect.innerHTML = '<option value="">-- Comunidad --</option>';

                comunidades.forEach(comunidad => {
                    comunidadSelect.innerHTML += `
                    <option value="${comunidad.id}" ${comunidad.id == selectedComunidad ? 'selected' : ''}>
                        ${comunidad.name}
                    </option>`;
                });
            });
    }
});

//MODALS BEHAVIOR
document.addEventListener('DOMContentLoaded', () => {
    // Generic function to open a modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex'; // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex', 'opacity-100');
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }

    // Generic function to close a modal
    function closeModal(modal) {
        modal.style.display = 'none'; // Hide modal
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-100');
    }

    // Handle modal close buttons
    document.querySelectorAll('.modal .btn-close, .modal .btn-secondary').forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });

    // Close modal on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });

    // Handle opening "Codigo Ubicacion" modal
    document.querySelectorAll('.editar-codigo-ubicacion').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const codigoUbicacion = this.getAttribute('data-codigo-ubicacion');

            document.getElementById('corregimiento-id-modal').value = id;
            if (codigoUbicacion) {
                document.getElementById('codigo_ubicacion').value = codigoUbicacion;
            }

            openModal('addCodigoUbicacionModal');
        });
    });

    // Handle opening "Nueva Comunidad" modal when user selects "__add_new__"
    const comunidadSelect = document.getElementById('idComunidad');
    if (comunidadSelect) {
        comunidadSelect.addEventListener('change', function () {
            if (this.value === '__add_new__') {
                const corregimientoId = document.getElementById('idCorregimiento').value;
                if (!corregimientoId) {
                    alert("Por favor, selecciona un corregimiento antes de agregar una nueva comunidad.");
                    return;
                }

                document.getElementById('corregimiento_id_modal').value = corregimientoId;
                openModal('addComunidadModal');
            }
        });
    }
});

document.querySelector('[name="areaTerreno"]').addEventListener('input', function (e) {
    numberValidate(e);
});

document.querySelector('[name="valorTerreno"]').addEventListener('input', function (e) {
    numberValidate(e);
});

document.querySelector('[name="valorMejora"]').addEventListener('input', function (e) {
    numberValidate(e);
});

document.getElementById('areaMin').addEventListener('input', function (e){
    numberValidate(e);
});

document.getElementById('areaMax').addEventListener('input', function (e){
    numberValidate(e);
});

document.getElementById('valorTerrenoMin').addEventListener('input', function (e){
    numberValidate(e);
});

document.getElementById('valorTerrenoMax').addEventListener('input', function (e){
    numberValidate(e);
});

document.getElementById('valorMejoraMin').addEventListener('input', function (e){
    numberValidate(e);
});

document.getElementById('valorMejoraMax').addEventListener('input', function (e){
    numberValidate(e);
});

function numberValidate(e){
    let value = e.target.value;

    // Remove all invalid characters: keep only numbers and a single period for decimals
    value = value.replace(/[^0-9.]/g, '');

    // If the first character is a ".", prepend "0"
    if (value.startsWith('.')) {
        value = '0' + value;
    }

    // Prevent multiple decimal points
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts[1]; // Retain only the first two parts
    }

    // Ensure decimals don't exceed 2 places
    if (parts[1]?.length > 2) {
        value = parts[0] + '.' + parts[1].substring(0, 2);
    }

    // Disallow negative values entirely
    value = value.replace(/^-/, '');

    // Update the input value after sanitization
    e.target.value = value;
}

document.getElementById('busquedaForm').addEventListener('submit', function(e){
    let mensaje = "";
    
    if(document.getElementById('areaMin').value != "" && document.getElementById('areaMax').value != ""){
        if(Number(document.getElementById('areaMin').value) > Number(document.getElementById('areaMax').value)){
            mensaje += "El área de búsqueda mínima no puede ser mayor al área máxima.\n";
        }
    }

    if(document.getElementById('valorTerrenoMin').value != "" && document.getElementById('valorTerrenoMax').value != ""){
        if(Number(document.getElementById('valorTerrenoMin').value) > Number(document.getElementById('valorTerrenoMax').value)){
            mensaje += "El valor mínimo del terreno en búsqueda no puede ser mayor al valor máxima del terreno.\n";
        }
    }

    if(document.getElementById('valorMejoraMin').value != "" && document.getElementById('valorMejoraMax').value != ""){
        if(Number(document.getElementById('valorMejoraMin').value) > Number(document.getElementById('valorMejoraMax').value)){
            mensaje += "El valor mínimo de la mejora en búsqueda no puede ser mayor al valor máxima de la mejora.\n";
        }
    }

    if(document.getElementById('fechaFin').value != "" && document.getElementById('fechaInicio').value != ""){
        if(document.getElementById('fechaFin').value < document.getElementById('fechaInicio').value){
            mensaje += "La fecha inicial no puede ser mayor a la fecha final.\n";
        }
    }

    if(mensaje){
        event.preventDefault();
        alert(mensaje);
    }
});