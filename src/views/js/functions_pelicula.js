async function listar_peliculas() {
    try {
        // Llamada al controlador de películas
        let respuesta = await fetch(base_url + 'src/controller/pelicula.php?tipo=listar');
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
                    <td>${item.genero}</td>                    
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



/*async function registrar_pelicula() {
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
        let respuesta = await fetch(base_url + 'src/controller/pelicula.php?tipo=registrar', {
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

*/


/*// 3️⃣ Cargar película y marcar géneros
async function cargarPelicula(id) {
    try {
        let res = await fetch(base_url + 'src/controller/pelicula.php?tipo=ver&id=' + id);
        let json = await res.json();

        if (json.status) {
            let p = json.data;
            document.getElementById('pelicula_id').value = p.id;
            document.getElementById('titulo').value = p.titulo;
            document.getElementById('descripcion').value = p.descripcion;
            document.getElementById('anio_estreno').value = p.anio_estreno;
            document.getElementById('duracion').value = p.duracion;
            document.getElementById('idioma').value = p.idioma;
            document.getElementById('calificacion').value = p.calificacion;

            await listar_generos(); // cargar todos los géneros

            // 4️⃣ Marcar géneros existentes
            let select = document.getElementById('generos');
            Array.from(select.options).forEach(opt => {
                if (p.generos.includes(parseInt(opt.value))) {
                    opt.selected = true;
                }
            });
        } else {
            swal("Error", "No se pudo cargar la película", "error");
        }
    } catch (e) {
        console.log("Error al cargar la película: " + e);
    }
}

// 5️⃣ Guardar cambios
async function editar_pelicula() {
    let frm = document.getElementById('frmEditarPelicula');
    let generos = Array.from(document.getElementById('generos').selectedOptions)
                        .map(o => o.value)
                        .filter(v => v !== "");

    if (generos.length === 0) {
        alert("Debes seleccionar al menos un género");
        return;
    }

    const datos = new FormData(frm);
    datos.append('generos', JSON.stringify(generos));

    try {
        let res = await fetch(base_url + 'src/controller/pelicula.php?tipo=editar', {
            method: 'POST',
            body: datos
        });
        let json = await res.json();
        if (json.status) {
            swal("Actualizado", json.mensaje, "success");
        } else {
            swal("Error", json.mensaje, "error");
        }
    } catch (e) {
        console.log("Error al editar: " + e);
    }
}

function getIdFromPath() {
    const path = window.location.pathname; // /peliculas/editar-pelicula/7
    const parts = path.split('/');
    return parts[parts.length - 1]; // devuelve 7
}

window.onload = async function() {
    const peliculaId = getIdFromPath();
    if (peliculaId) {
        await cargarPelicula(peliculaId);
    } else {
        swal("Error", "No se especificó el ID de la película", "error");
    }
};*/
