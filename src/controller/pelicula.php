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
        <a href="' . BASE_URL . 'editar-pelicula.php?id=' . $id_pelicula . '" class="btn btn-warning btn-sm d-inline-flex align-items-center">
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

