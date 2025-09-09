<?php
require_once('../model/peliculaModel.php');
require_once('../model/generoModel.php');

$tipo = $_REQUEST['tipo'];

$objPelicula = new PeliculaModel();
$objGenero = new GeneroModel();

if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_peliculas = $objPelicula->obtener_peliculas();

    if (!empty($arr_peliculas)) {
        for ($i = 0; $i < count($arr_peliculas); $i++) {
            $id_pelicula = $arr_peliculas[$i]->id;

        // Obtener todos los géneros de la película (muchos a muchos)
           $r_generos = $objGenero->obtener_generos_por_pelicula($id_pelicula); 
             //$r_generos debería ser un array de nombres
            $arr_peliculas[$i]->genero = $r_generos;

            // Botones de acción
            $opciones = '
            <a href="' . BASE_URL . 'editar-pelicula.php?id=' . $id_pelicula . '" class="btn btn-warning">
    <i class="fa fa-pencil"></i> Editar
</a>

            <button onclick="eliminar_pelicula(' . $id_pelicula . ');" class="btn btn-danger">
                <i class="fa fa-trash"></i> Eliminar
            </button>';

            $arr_peliculas[$i]->options = $opciones;
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_peliculas;
    }

    echo json_encode($arr_Respuestas);
}


if ($tipo == "registrar" && $_POST) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $anio_estreno = $_POST['anio_estreno'];
    $duracion = $_POST['duracion'];
    $idioma = $_POST['idioma'];
    $calificacion = $_POST['calificacion'];
    $generos = json_decode($_POST['generos'], true); // Array de géneros

    if (empty($titulo) || empty($descripcion) || empty($anio_estreno) || empty($duracion) || empty($idioma) || empty($calificacion) || empty($generos)) {
        echo json_encode(['status' => false, 'mensaje' => 'Campos vacíos']);
        exit;
    }

    $idNueva = $objPelicula->registrarPelicula($titulo, $descripcion, $anio_estreno, $duracion, $idioma, $calificacion);

    if ($idNueva > 0) {
        foreach ($generos as $idGenero) {
            if (!empty($idGenero)) {
                $objPelicula->asignarGenero($idNueva, $idGenero);
            }
        }
        echo json_encode(['status' => true, 'mensaje' => 'Película registrada correctamente']);
    } else {
        echo json_encode(['status' => false, 'mensaje' => 'Error al registrar la película']);
    }
}

/*
if ($tipo == "ver" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $pelicula = $objPelicula->verPeliculas($id);
    $generos = $objPelicula->verGeneros($id);
    $pelicula->generos = $generos;
    echo json_encode(['status'=>true,'data'=>$pelicula], JSON_UNESCAPED_UNICODE);
}

if ($tipo == "editar" && $_POST) {
    $id = $_POST['pelicula_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $anio = $_POST['anio_estreno'];
    $duracion = $_POST['duracion'];
    $idioma = $_POST['idioma'];
    $calificacion = $_POST['calificacion'];
    $generos = json_decode($_POST['generos'], true);

    if(empty($id) || empty($titulo) || empty($descripcion) || empty($anio) || empty($duracion) || empty($idioma) || empty($calificacion) || empty($generos)) {
        echo json_encode(['status'=>false,'mensaje'=>'Campos vacíos']); exit;
    }

    $res = $objPelicula->editarPelicula($id,$titulo,$descripcion,$anio,$duracion,$idioma,$calificacion);

    if($res){
        $objPelicula->eliminarGeneros($id);
        foreach($generos as $gid){
            if(!empty($gid)) $objPelicula->asignarGenero($id,$gid);
        }
        echo json_encode(['status'=>true,'mensaje'=>'Película actualizada correctamente']);
    } else {
        echo json_encode(['status'=>false,'mensaje'=>'Error al actualizar la película']);
    }
}*/

