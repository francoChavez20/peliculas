<?php
require_once('../model/peliculaModel.php');


$tipo = $_REQUEST['tipo'];

$objPelicula = new PeliculaModel();


if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_peliculas = $objPelicula->obtener_peliculas();

    if (!empty($arr_peliculas)) {
        for ($i = 0; $i < count($arr_peliculas); $i++) {
            $id_pelicula = $arr_peliculas[$i]->id;

            // El género ya viene directo de la tabla (no se hace consulta adicional)
            $arr_peliculas[$i]->genero = $arr_peliculas[$i]->genero;

            // Botones de acción
            $opciones = '
           
    <div class="d-flex justify-content-start gap-2">
        <a href="' .BASE_URL.'editar-pelicula/'. $id_pelicula.'" class="btn btn-warning btn-sm d-inline-flex align-items-center">
            <i class="fa fa-pencil"></i> Editar
        </a>
        <button onclick="eliminar_pelicula(' . $id_pelicula . ');" class="btn btn-danger btn-sm d-inline-flex align-items-center">
            <i class="fa fa-trash"></i> Eliminar
        </button>
    </div>';


            $arr_peliculas[$i]->options = $opciones;
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_peliculas;
    }

    echo json_encode($arr_Respuestas);
}


if ($tipo == "registrar") {
    if ($_POST) {
        $titulo       = $_POST['titulo'];
        $descripcion  = $_POST['descripcion'];
        $anio_estreno = $_POST['anio_estreno'];
        $duracion     = $_POST['duracion'];
        $calificacion = $_POST['calificacion'];
        $idioma       = $_POST['idioma'];
        $genero       = $_POST['genero'];

        if ($titulo == "" || $descripcion == "" || $anio_estreno == "" || $duracion == "" || 
            $calificacion == "" || $idioma == "" || $genero == "") {

            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $arrPelicula = $objPelicula->registrarPelicula($titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero);

            if ($arrPelicula['id'] > 0) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Película registrada con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al registrar película');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}

/* === EDITAR PELÍCULA === */
if ($tipo == "editar") {
    if ($_POST) {
        $id           = $_POST['id_pelicula'];
        $titulo       = $_POST['titulo'];
        $descripcion  = $_POST['descripcion'];
        $anio_estreno = $_POST['anio_estreno'];
        $duracion     = $_POST['duracion'];
        $calificacion = $_POST['calificacion'];
        $idioma       = $_POST['idioma'];
        $genero       = $_POST['genero'];

        if ($id == "" || $titulo == "" || $descripcion == "" || $anio_estreno == "" || 
            $duracion == "" || $calificacion == "" || $idioma == "" || $genero == "") {

            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $editado = $objPelicula->editarPelicula(
                $id, $titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero
            );

            if ($editado) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Película actualizada con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al actualizar película');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}

/* === VER PELÍCULA (para precargar el form) === */
if ($tipo == "ver") {
    if ($_POST) {
        $id = $_POST['id_pelicula'];
        $pelicula = $objPelicula->obtenerPelicula($id);

        if ($pelicula) {
            $arr_Respuestas = array('status' => true, 'contenido' => $pelicula);
        } else {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Película no encontrada');
        }
        echo json_encode($arr_Respuestas);
    }
}


if ($tipo == "eliminar") {
    $id_pelicula = $_POST['id_pelicula'];
    
    try {
        $arr_Respuesta = $objPelicula->eliminarPelicula($id_pelicula);
        
        if ($arr_Respuesta) {
            $response = array(
                'status' => true,
                'message' => 'Película eliminada correctamente.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'No se encontró la película o no pudo ser eliminada.'
            );
        }
    } catch (PDOException $e) {
        // Verificamos si el error es debido a una restricción de clave foránea
        if ($e->getCode() == '23000') { // Código SQLSTATE para restricciones de integridad
            $response = array(
                'status' => false,
                'message' => 'No se puede eliminar esta película porque está asociada a otros registros.'
            );
        } else {
            // Otro tipo de error
            $response = array(
                'status' => false,
                'message' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            );
        }
    }

    echo json_encode($response);
}

?>
