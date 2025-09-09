// Llenar el select de géneros
async function listar_generos() {
    try {
        let respuesta = await fetch(base_url + 'src/controller/genero.php?tipo=listar', {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        });

        let json = await respuesta.json();

        if (json.status) {
            let select = document.getElementById('generos');
            select.innerHTML = ""; // limpiar opciones previas

            json.data.forEach(genero => {
                let option = document.createElement("option");
                option.value = genero.id;
                option.text = genero.nombre;
                select.add(option);
            });
        } else {
            console.log("Error al listar géneros:", json.mensaje);
        }

    } catch (e) {
        console.log("Oops, ocurrió un error: " + e);
    }
}
