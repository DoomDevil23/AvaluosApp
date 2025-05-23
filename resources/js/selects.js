document.addEventListener('DOMContentLoaded', function () {
    if(document.getElementById('provincia')){
        fetch('/provincias')
        .then(res => res.json())
        .then(data => {
            let provinciaSelect = document.getElementById('provincia');
            data.forEach(p => {
                provinciaSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        });
        fetch('/provincias')
        .then(res => res.json())
        .then(data => {
            let provinciaSelect = document.getElementById('idProvincia');
            data.forEach(p => {
                provinciaSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        });

        //TIPO MEJORA
        if(document.getElementById('tipoMejora')){

            fetch('/tipomejoras')
            .then(res => res.json())
            .then(data => {
                let idTipoMejoraSelect = document.getElementById('tipoMejora');
                data.forEach(p => {
                    idTipoMejoraSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                });
            });

            fetch('/tipomejoras')
            .then(res => res.json())
            .then(data => {
                let idTipoMejoraSelect = document.getElementById('idTipoMejora');
                data.forEach(p => {
                    idTipoMejoraSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                });
            });
        }
    }
});

if(document.getElementById('provincia')){
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
                    //if(document.getElementById('idCorregimniento'))
                        document.getElementById('idCorregimiento').innerHTML = '<option value="">Seleccionar</option>';
                    if(document.getElementById('idComunidad'))
                        document.getElementById('idComunidad').innerHTML = '<option value="">Seleccionar</option>';
                })
                .catch(error => console.error('Error fetching distritos:', error));
        } else {
            // If no provincia is selected, clear the distrito select options
            document.getElementById('distrito').innerHTML = '<option value="">Seleccionar</option>';
            document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
            if(document.getElementById('comunidad'))
                document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });
}

if(document.getElementById('distrito')){
    document.getElementById('distrito').addEventListener('change', function () {
        let distritoId = this.value;  // Get selected distrito ID
        if (distritoId) {
            // Fetch corregimientos for the selected distrito
            fetch(`/corregimientos/${distritoId}`)
                .then(res => res.json())
                .then(data => {
                    let corregimientoSelect = document.getElementById('idCorregimiento');
                    // Clear previous options and add the default one
                    corregimientoSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(c => {
                        // Append each corregimiento as an option
                        corregimientoSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                    });

                    // Clear the comunidad select
                    if(document.getElementById('comunidad'))
                        document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
                })
                .catch(error => console.error('Error fetching corregimientos:', error));
        } else {
            // If no distrito is selected, clear the corregimiento and comunidad select options
            document.getElementById('corregimiento').innerHTML = '<option value="">Seleccionar</option>';
            if(document.getElementById('comunidad'))
                document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });
}

if(document.getElementById('idCorregimiento') && document.getElementById('idComunidad')){
    document.getElementById('idCorregimiento').addEventListener('change', function () {
        let corregimientoId = this.value;  // Get selected corregimiento ID
        if (corregimientoId) {
            // Fetch comunidades for the selected corregimiento
            fetch(`/comunidades/${corregimientoId}`,{
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    let comunidadSelect = document.getElementById('idComunidad');
                    // Clear previous options and add the default one
                    comunidadSelect.innerHTML = '<option value="">Seleccionar</option>';
                    data.forEach(com => {
                        // Append each comunidad as an option
                        comunidadSelect.innerHTML += `<option value="${com.id}">${com.name}</option>`;
                    });
                    comunidadSelect.innerHTML += `<option value="__add_new__">➕ Nueva comunidad</option>`;
                })
                .catch(error => console.error('Error fetching comunidades:', error));
        } else {
            // If no corregimiento is selected, clear the comunidad select options
            document.getElementById('comunidad').innerHTML = '<option value="">Seleccionar</option>';
        }
    });
}

if(document.getElementById('idProvincia')){
    document.getElementById('idProvincia').addEventListener('change', function () {
        const provinciaId = this.value;
        document.getElementById('idDistrito').innerHTML = '<option value="">Seleccionar</option>';
        document.getElementById('idCorregimientoBuscar').innerHTML = '<option value="">Seleccionar</option>';
        if(document.getElementById('idComunidadBuscar'))
            document.getElementById('idComunidadBuscar').innerHTML = '<option value="">Seleccionar</option>';
        if(provinciaId){
            fetch(`/distritos/${provinciaId}`)
                .then(response => response.json())
                .then(data => {
                    const distritoSelect = document.getElementById('idDistrito');
                    distritoSelect.innerHTML = '<option value="">-- Distrito --</option>';
                    data.forEach(distrito => {
                        distritoSelect.innerHTML += `<option value="${distrito.id}">${distrito.name}</option>`;
                    });
                });
        }
    });
}

if(document.getElementById('idDistrito')){
    document.getElementById('idDistrito').addEventListener('change', function(){
        const distritoId = this.value;
        document.getElementById('idCorregimiento').innerHTML = '<option value="">Seleccionar</option>';
        if(document.getElementById('idComunidad'))
            document.getElementById('idComunidad').innerHTML = '<option value="">Seleccionar</option>';
        if(distritoId){
            fetch(`/corregimientos/${distritoId}`)
                .then(response => response.json())
                .then(data =>{
                    const corregimientoSelect = document.getElementById('idCorregimientoBuscar');
                    corregimientoSelect.innerHTML = '<option value="">-- Corregimiento --</option>';
                    data.forEach(corregimiento =>{
                        corregimientoSelect.innerHTML += `<option value="${corregimiento.id}">${corregimiento.name}</option>`;
                    });
                });
        }
    });
}

if(document.getElementById('idCorregimientoBuscar') && document.getElementById('idComunidadBuscar')){
    document.getElementById('idCorregimientoBuscar').addEventListener('change', function () {
        const corregimientoId = this.value;
        fetch(`/comunidades/${corregimientoId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // This tells Laravel it's an AJAX request
            }
        })
            .then(response => response.json())
            .then(data => {
                const comunidadSelect = document.getElementById('idComunidadBuscar');
                comunidadSelect.innerHTML = '<option value="">-- Comunidad --</option>';
                data.forEach(comunidad => {
                    comunidadSelect.innerHTML += `<option value="${comunidad.id}">${comunidad.name}</option>`;
                });
                
            });
    });
}