async function listar_peliculas() {
    try {
        // Llamada al controlador de películas
        let respuesta = await fetch(base_url+'src/controller/pelicula.php?tipo=listar');
        let json = await respuesta.json();

        if (json.status) {
            let datos = json.contenido;
            let cont = 0;

            datos.forEach(item => {
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila_" + item.id;
                cont += 1;

                // Se llena la fila con los datos de la película
                nueva_fila.innerHTML = `
                    <th>${cont}</th>
                    <td>${item.titulo}</td>
                    <td>${item.descripcion}</td>
                    <td>${item.anio_estreno}</td>
                    <td>${item.duracion} min</td>
                    <td>${item.calificacion}</td>
                    <td>${item.idioma}</td>
                    <td>${item.genero.join(', ')}</td>                    
                    <td>${item.options}</td>
                `;

                document.querySelector('#tbl_peliculas').appendChild(nueva_fila);
            });
        }

        console.log(json);
    } catch (error) {
        console.log("Oops, salió error: " + error);
    }
}

// Ejecutar solo si existe la tabla
if (document.querySelector('#tbl_peliculas')) {
    listar_peliculas();
}


async function registrar_pelicula() {
    let frm = document.getElementById('frmRegistrarPelicula');

    // Capturar los géneros seleccionados
    let generos = Array.from(document.getElementById('generos').selectedOptions)
                        .map(option => option.value)
                        .filter(val => val !== ""); // elimina valores vacíos

    if (generos.length === 0) {
        alert("Debes seleccionar al menos un género.");
        return;
    }

    const datos = new FormData(frm);
    // Agregar los géneros como JSON
    datos.append('generos', JSON.stringify(generos));

    try {
        let respuesta = await fetch(base_url + 'src/controller/Pelicula.php?tipo=registrar', {
            method: 'POST',
            body: datos
        });

        let json = await respuesta.json();

        if (json.status) {
            swal("Registro", json.mensaje, "success");
            frm.reset(); // Limpiar formulario
        } else {
            swal("Error", json.mensaje, "error");
        }

    } catch (e) {
        console.log("Oops, ocurrió un error: " + e);
    }
}
