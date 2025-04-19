//UPDATE
document.querySelectorAll('.editar-comunidad').forEach(button => {
    button.addEventListener('click', function () {
        // Get data from button attributes
        const id = this.getAttribute('dataId');
        const nombreComunidad = this.getAttribute('dataNombreComunidad');
        const idCorregimiento = this.getAttribute('dataIdCorregimiento');

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

        document.querySelector('#comunidadForm button[type="submit"]').textContent = 'Actualizar Comunidad';
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
    document.querySelector('#comunidadForm button[type="submit"]').textContent = 'Guardar Comunidad';
    document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
    document.getElementById('idCorregimiento').innerHTML = '<option value="">Seleccionar</option>';
});