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


async function registrar_pelicula() {
    // Obtener valores de los inputs
    let titulo = document.querySelector('#titulo').value;
    let descripcion = document.querySelector('#descripcion').value;
    let anio_estreno = document.querySelector('#anio_estreno').value;
    let duracion = document.querySelector('#duracion').value;
    let calificacion = document.querySelector('#calificacion').value;
    let idioma = document.querySelector('#idioma').value;
    let genero = document.querySelector('#genero').value;

    // Validación básica
    if (
        titulo === "" ||
        descripcion === "" ||
        anio_estreno === "" ||
        duracion === "" ||
        calificacion === "" ||
        idioma === "" ||
        genero === ""
    ) {
        swal("Error", "Todos los campos son obligatorios", "error");
        return;
    }

    try {
        // Capturamos el formulario
        const datos = new FormData(frmRegistrarPelicula);

        // Enviamos al controlador PHP
        let respuesta = await fetch(base_url + 'src/controller/pelicula.php?tipo=registrar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();

        if (json.status) {
            swal("Registro", json.mensaje, "success");
            frmRegistrarPelicula.reset(); // limpiar formulario
        } else {
            swal("Registro", json.mensaje, "error");
        }

        console.log(json);
    } catch (e) {
        console.log("Oops ocurrió un error: " + e);
    }
}

async function editar_pelicula(id) {
    const formData = new FormData();
    formData.append('id_pelicula', id);

    try {
        let respuesta = await fetch(base_url + 'src/controller/pelicula.php?tipo=ver', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });

        const json = await respuesta.json();

        if (json.status) {
            // Guardamos el ID en el hidden
            document.querySelector('#id_pelicula').value = json.contenido.id;

            // Llenamos los demás campos
            document.querySelector('#titulo').value = json.contenido.titulo;
            document.querySelector('#descripcion').value = json.contenido.descripcion;
            document.querySelector('#anio_estreno').value = json.contenido.anio_estreno;
            document.querySelector('#duracion').value = json.contenido.duracion;
            document.querySelector('#calificacion').value = json.contenido.calificacion;
            document.querySelector('#idioma').value = json.contenido.idioma;
            document.querySelector('#genero').value = json.contenido.genero;

        } else {
            window.location = base_url + "peliculas";
        }

    } catch (error) {
        console.log("Oops, ocurrió un error: " + error);
    }
}


async function actualizar_pelicula() {
    // Tomamos los valores del formulario
    const id = document.querySelector('#id_pelicula').value; // Necesitas un input hidden con el id
    const titulo = document.querySelector('#titulo').value;
    const descripcion = document.querySelector('#descripcion').value;
    const anio_estreno = document.querySelector('#anio_estreno').value;
    const duracion = document.querySelector('#duracion').value;
    const calificacion = document.querySelector('#calificacion').value;
    const idioma = document.querySelector('#idioma').value;
    const genero = document.querySelector('#genero').value;

    // Validación simple
    if (!titulo || !descripcion || !anio_estreno || !duracion || !calificacion || !idioma || !genero) {
        swal("Error", "Por favor completa todos los campos", "error");
        return;
    }

    try {
        const formData = new FormData();
        formData.append('id_pelicula', id);
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('anio_estreno', anio_estreno);
        formData.append('duracion', duracion);
        formData.append('calificacion', calificacion);
        formData.append('idioma', idioma);
        formData.append('genero', genero);

        let respuesta = await fetch(base_url + 'src/controller/pelicula.php?tipo=editar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });

        const json = await respuesta.json();

        if (json.status) {
            swal("Éxito", json.mensaje, "success")
                .then(() => {
                    window.location = base_url + "peliculas"; // Redirige al listado
                });
        } else {
            swal("Error", json.mensaje, "error");
        }

        console.log(json);

    } catch (error) {
        console.log("Oops, ocurrió un error: " + error);
    }
}


