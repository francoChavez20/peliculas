async function llamar_api() {
    const formulario = document.getElementById('frmApi');
    const datos = new FormData(formulario);
    let ruta_api = document.getElementById('ruta_api').value;

    try {

        let respuesta = await fetch(ruta_api + '/src/controller/api-request.php?tipo=verPeliculasApiByNombre', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();

        let contenidoHTML = '';
        let contador = 0;

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

        document.getElementById('contenido').innerHTML = contenidoHTML;

    } catch (error) {
        console.error('Error al llamar a la API:', error);
    }
}
