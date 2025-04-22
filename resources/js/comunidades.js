//const { document } = require("postcss");

//UPDATE
document.querySelectorAll('.editar-comunidad').forEach(button => {
    button.addEventListener('click', function () {
        // Get data from button attributes
        const id = this.getAttribute('data-id');
        const nombreComunidad = this.getAttribute('data-name');
        const idCorregimiento = this.getAttribute('data-idcorregimiento');

        // Set form values
        document.getElementById('idComunidad').value = id;
        document.querySelector('[name="name"]').value = nombreComunidad;

        // Comunidad requires fetching provincia → distrito → corregimiento
        // We'll handle this next 👇

        // Simulate selecting Comunidad (load chain if necessary)
        fetch(`/comunidad-info/${id}`)
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
                    });
            })
            .catch(error => {
                console.error('Error cargando comunidad y ubicación:', error);
            });

        // Opcional: desplazarse al formulario
        window.scrollTo({ top: 0, behavior: 'smooth' });

        const form = document.getElementById('comunidadForm');
        //form.action = '/comunidades/'+document.getElementById('idComunidad').value;
        form.action = "/comunidades/"+document.getElementById('idComunidad').value;
        console.log(document.getElementById('idComunidad').value);
        document.getElementById('formMethod').value = 'PUT';

        document.querySelector('#comunidadForm button[type="submit"]').textContent = 'Actualizar';
        document.getElementById('cancelarEdicionComunidad').style.display = 'inline-block';
    })
});

document.getElementById('cancelarEdicionComunidad').addEventListener('click', function () {
    const form = document.getElementById('comunidadForm');
    form.reset();
    form.action = "{{ route('comunidades.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('idComunidad').value = '';
    this.style.display = 'none';
    document.querySelector('#comunidadForm button[type="submit"]').textContent = 'Guardar';
    document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
    document.getElementById('idCorregimiento').innerHTML = '<option value="">Seleccionar</option>';
});

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    
    // Check if there are any query parameters before proceeding
    if (!params.toString()) {
        return; // Exit script if no filters are present
    }

    // Retrieve selected values if they exist
    const selectedName = params.get('name');
    const selectedProvincia = params.get('idProvincia');
    const selectedDistrito = params.get('idDistrito');
    const selectedCorregimiento = params.get('idCorregimiento');

    if(selectedName){
        document.getElementById('nameBuscar').value = selectedName;
    }

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
});