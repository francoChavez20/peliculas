<style>
    .form-container {
        margin: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh; /* ocupa toda la altura de la pantalla */
        background-color: #f0f2f5;
    }

    .form {
        background-color: #ffffff;
        margin: 20px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 700px;
        font-family: Arial, sans-serif;
    }

    .form div {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .form-column {
        flex: 1;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="file"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    textarea {
        resize: vertical;
        min-height: 60px;
    }

    .button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #45a049;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #4CAF50;
        outline: none;
        background-color: #f1f9f1;
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>
<div class="form-container">
    <form class="form" id="frmEditarPelicula">
        <h2>Editar Película</h2>

        <!-- ID oculto -->
        <input type="hidden" id="pelicula_id" name="pelicula_id">

        <div>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>

        <div>
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-column">
                <label for="anio_estreno">Año de Estreno</label>
                <input type="number" id="anio_estreno" name="anio_estreno" required>
            </div>
            <div class="form-column">
                <label for="duracion">Duración (minutos)</label>
                <input type="number" id="duracion" name="duracion" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <label for="idioma">Idioma</label>
                <input type="text" id="idioma" name="idioma" required>
            </div>
            <div class="form-column">
                <label for="calificacion">Calificación</label>
                <input type="text" id="calificacion" name="calificacion" required>
            </div>
        </div>

        <div>
            <label for="generos">Géneros</label>
            <select name="generos[]" id="generos" multiple required></select>

            <small>Puedes seleccionar varios manteniendo presionada la tecla CTRL o SHIFT.</small>
        </div>

        <button type="button" class="button" onclick="editar_pelicula();">Guardar Cambios</button>
        <!-- scripts al final del body -->
<script src="<?php echo BASE_URL ?>src/views/js/functions_pelicula.js"></script>
<script src="<?php echo BASE_URL ?>src/views/js/functions_genero.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
// Función para obtener parámetros de la URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Al cargar la página, cargar la película correspondiente
window.onload = function() {
    const peliculaId = getQueryParam('id'); // toma ?id=3
    if (peliculaId) {
        cargarPelicula(peliculaId);
    } else {
        swal("Error", "No se especificó el ID de la película", "error");
    }
};
</script>

    </form>
</div>
