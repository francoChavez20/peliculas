// ===================== LISTAR CLIENTES =====================
async function listar_clientes() {
    try {
        // Llamada al controlador de clientes
        let respuesta = await fetch(base_url + 'src/controller/cliente.php?tipo=listar');
        let json = await respuesta.json();

        if (json.status) {
            let datos = json.contenido;
            let cont = 0;

            datos.forEach(item => {
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila_" + item.id;
                cont += 1;

                // Se llena la fila con los datos del cliente
                nueva_fila.innerHTML = `
                    <th>${cont}</th>
                    <td>${item.dni}</td>
                    <td>${item.nombre}</td>
                    <td>${item.apellido}</td>
                    <td>${item.telefono}</td>
                    <td>${item.correo}</td>
                    <td>${item["fecha-registro"]}</td>
                    <td>${item.estado}</td>
                    <td>${item.options}</td>
                `;

                document.querySelector('#tbl_clientes').appendChild(nueva_fila);
            });
        }

        console.log(json);
    } catch (error) {
        console.log("Oops, salió error: " + error);
    }
}

// Ejecutar solo si existe la tabla
if (document.querySelector('#tbl_clientes')) {
    listar_clientes();
}


// ===================== REGISTRAR CLIENTE =====================
async function registrar_cliente() {
    let dni = document.querySelector('#dni').value;
    let nombre = document.querySelector('#nombre').value;
    let apellido = document.querySelector('#apellido').value;
    let telefono = document.querySelector('#telefono').value;
    let correo = document.querySelector('#correo').value;

    if (!dni || !nombre || !apellido || !telefono || !correo) {
        swal("Error", "Todos los campos son obligatorios", "error");
        return;
    }

    const formData = new FormData(document.querySelector('#frmRegistrarCliente'));
    const respuesta = await fetch(base_url + 'src/controller/cliente.php?tipo=registrar', {
        method: 'POST',
        body: formData
    });

    const json = await respuesta.json();

    if (json.status) {
        swal("Registro", json.mensaje, "success");
        document.querySelector('#frmRegistrarCliente').reset();
    } else {
        swal("Error", json.mensaje, "error");
    }
}


// ===================== EDITAR CLIENTE =====================
async function editar_cliente(id) {
    const formData = new FormData();
    formData.append('id_cliente', id);

    const respuesta = await fetch(base_url + 'src/controller/cliente.php?tipo=ver', {
        method: 'POST',
        body: formData
    });

    const json = await respuesta.json();
    if (json.status) {
        document.querySelector('#id_cliente').value = json.contenido.id;
        document.querySelector('#dni').value = json.contenido.dni;
        document.querySelector('#nombre').value = json.contenido.nombre;
        document.querySelector('#apellido').value = json.contenido.apellido;
        document.querySelector('#telefono').value = json.contenido.telefono;
        document.querySelector('#correo').value = json.contenido.correo;
        document.querySelector('#estado').value = json.contenido.estado;
    }
}


// ===================== ACTUALIZAR CLIENTE =====================
async function actualizar_cliente() {
    const id = document.querySelector('#id_cliente').value;
    const dni = document.querySelector('#dni').value;
    const nombre = document.querySelector('#nombre').value;
    const apellido = document.querySelector('#apellido').value;
    const telefono = document.querySelector('#telefono').value;
    const correo = document.querySelector('#correo').value;
    const estado = document.querySelector('#estado').value;

    if (!dni || !nombre || !apellido || !telefono || !correo) {
        swal("Error", "Por favor completa todos los campos", "error");
        return;
    }

    try {
        const formData = new FormData();
        formData.append('id_cliente', id);
        formData.append('dni', dni);
        formData.append('nombre', nombre);
        formData.append('apellido', apellido);
        formData.append('telefono', telefono);
        formData.append('correo', correo);
        formData.append('estado', estado);

        let respuesta = await fetch(base_url + 'src/controller/cliente.php?tipo=editar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });

        const json = await respuesta.json();

        if (json.status) {
            swal("Éxito", json.mensaje, "success")
                .then(() => {
                    window.location = base_url + "cliente";
                });
        } else {
            swal("Error", json.mensaje, "error");
        }

    } catch (error) {
        console.log("Oops, ocurrió un error: " + error);
    }
}


// ===================== ELIMINAR CLIENTE =====================
async function eliminar_cliente(id) {
    swal({
        title: "¿Estás seguro de eliminar este cliente?",
        text: "No podrás recuperarlo",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(async (willDelete) => {
        if (willDelete) {
            try {
                const formData = new FormData();
                formData.append('id_cliente', id);

                const respuesta = await fetch(base_url + 'src/controller/cliente.php?tipo=eliminar', {
                    method: 'POST',
                    body: formData
                });

                const json = await respuesta.json();

                if (json.status) {
                    swal("Éxito", json.message, "success")
                        .then(() => {
                            location.reload(); // recarga el listado
                        });
                } else {
                    swal("Error", json.message, "error");
                }

            } catch (error) {
                console.log("Error al eliminar cliente: " + error);
            }
        }
    });
}
