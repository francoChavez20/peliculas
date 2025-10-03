// ===================== LISTAR TOKENS =====================
async function listar_tokens() {
    try {
        let respuesta = await fetch(base_url + 'src/controller/token.php?tipo=listar');
        let json = await respuesta.json();

        if (json.status) {
            let datos = json.contenido;
            let cont = 0;

            datos.forEach(item => {
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila_" + item.id;
                cont += 1;

                nueva_fila.innerHTML = `
                    <th>${cont}</th>
                    <td>${item["id-cliente-api"]}</td>
                    <td>${item.token}</td>
                    <td>${item["fecha-registro"]}</td>
                    <td>${item.estado}</td>
                    <td>${item.options}</td>
                `;

                document.querySelector('#tbl_tokens').appendChild(nueva_fila);
            });
        }
    } catch (error) {
        console.log("Error al listar tokens: " + error);
    }
}

if (document.querySelector('#tbl_tokens')) {
    listar_tokens();
}
// ===================== CARGAR CLIENTES EN SELECT =====================
// ===================== CARGAR CLIENTES EN SELECT =====================
async function cargarClientes() {
    try {
        let respuesta = await fetch(base_url + 'src/controller/token.php?tipo=listarClientes');
        let json = await respuesta.json();

        if (json.status) {
            let select = document.querySelector('#id_cliente');
            select.innerHTML = '<option value="">Seleccione un cliente</option>'; // resetear

            json.contenido.forEach(cliente => {
                let option = document.createElement("option");
                option.value = cliente.id;          // ID de la tabla cliente_api
                option.textContent = cliente.nombre; // Nombre que se mostrará
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.log("Error al cargar clientes: " + error);
    }
}

// Ejecutar solo si el select existe en la página
if (document.querySelector('#id_cliente')) {
    cargarClientes();
}



// ===================== REGISTRAR TOKEN =====================
async function registrar_token() {
    let idCliente = document.querySelector('#id_cliente').value;
    let estado = document.querySelector('#estado').value;

    if (!idCliente || !estado) {
        swal("Error", "Todos los campos son obligatorios", "error");
        return;
    }

    const formData = new FormData(document.querySelector('#frmRegistrarToken'));
    const respuesta = await fetch(base_url + 'src/controller/token.php?tipo=registrar', {
        method: 'POST',
        body: formData
    });

    const json = await respuesta.json();

    if (json.status) {
        // Mostrar el token generado en la alerta
        swal("Registro", `${json.mensaje}\nToken: ${json.token}\nFecha: ${json.fecha}`, "success");
        document.querySelector('#frmRegistrarToken').reset();
    } else {
        swal("Error", json.mensaje, "error");
    }
}



// ===================== EDITAR TOKEN =====================
async function editar_token(id) {
    const formData = new FormData();
    formData.append('id_token', id);

    const respuesta = await fetch(base_url + 'src/controller/token.php?tipo=ver', {
        method: 'POST',
        body: formData
    });

    const json = await respuesta.json();
    if (json.status) {
        document.querySelector('#id_token').value = json.contenido.id;
        document.querySelector('#id_cliente').value = json.contenido["id-cliente-api"];
        document.querySelector('#token').value = json.contenido.token;
        document.querySelector('#estado').value = json.contenido.estado;
    }
}


// ===================== ACTUALIZAR TOKEN =====================
async function actualizar_token() {
    const id = document.querySelector('#id_token').value;
    const idCliente = document.querySelector('#id_cliente').value;
    const token = document.querySelector('#token').value;
    const estado = document.querySelector('#estado').value;

    if (!idCliente || !token) {
        swal("Error", "Por favor completa todos los campos", "error");
        return;
    }

    try {
        const formData = new FormData();
        formData.append('id_token', id);
        formData.append('id_cliente', idCliente);
        formData.append('token', token);
        formData.append('estado', estado);

        let respuesta = await fetch(base_url + 'src/controller/token.php?tipo=editar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });

        const json = await respuesta.json();

        if (json.status) {
            swal("Éxito", json.mensaje, "success")
                .then(() => {
                    window.location = base_url + "token";
                });
        } else {
            swal("Error", json.mensaje, "error");
        }

    } catch (error) {
        console.log("Error al actualizar token: " + error);
    }
}


// ===================== ELIMINAR TOKEN =====================
async function eliminar_token(id) {
    swal({
        title: "¿Estás seguro de eliminar este token?",
        text: "No podrás recuperarlo",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(async (willDelete) => {
        if (willDelete) {
            try {
                const formData = new FormData();
                formData.append('id_token', id);

                const respuesta = await fetch(base_url + 'src/controller/token.php?tipo=eliminar', {
                    method: 'POST',
                    body: formData
                });

                const json = await respuesta.json();

                if (json.status) {
                    swal("Éxito", json.message, "success")
                        .then(() => {
                            location.reload();
                        });
                } else {
                    swal("Error", json.message, "error");
                }

            } catch (error) {
                console.log("Error al eliminar token: " + error);
            }
        }
    });
}
