async function llamar_api() {
    const formulario = document.getElementById('frmApi');
    const datos = new FormData(formulario);
    let ruta_api = document.getElementById('ruta_api').value;

    try {
        // Llamada a la API
        let respuesta = await fetch(ruta_api + '/src/controller/api-request.php?tipo=verPeliculasApiByNombre', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        // Convertimos la respuesta a JSON
        let json = await respuesta.json();

        // Variable para generar las filas de la tabla
        let contenidoHTML = '';
        let contador = 0;

        // Recorremos el arreglo de películas
        json.contenido.forEach(pelicula => {
            contador++;
            contenidoHTML += "<tr>";
            contenidoHTML += "<td>" + contador + "</td>";
            contenidoHTML += "<td>" + pelicula.titulo + "</td>";
            contenidoHTML += "<td>" + pelicula.descripcion + "</td>";
            contenidoHTML += "<td>" + pelicula.anio_estreno + "</td>";
            contenidoHTML += "<td>" + pelicula.duracion + "</td>";
            contenidoHTML += "<td>" + pelicula.calificacion + "</td>";
            contenidoHTML += "<td>" + pelicula.idioma + "</td>";
            contenidoHTML += "<td>" + pelicula.genero + "</td>";
            contenidoHTML += "</tr>";
        });

        // Insertamos las filas en la tabla HTML
        document.getElementById('contenido').innerHTML = contenidoHTML;

    } catch (error) {
        console.error('Error al llamar a la API:', error);
    }
}
