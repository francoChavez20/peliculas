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
            <a href="' . BASE_URL . 'editar-pelicula/' . $id_pelicula . '" class="btn btn-warning">
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
