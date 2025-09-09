<?php
require_once "../model/generoModel.php";  // modelo de la tabla generos
$objGenero = new GeneroModel();

$tipo = $_GET['tipo'] ?? '';

if ($tipo == "listar") {
    $generos = $objGenero->listarGeneros(); // traer todos los géneros
    if ($generos) {
        $arr_Respuestas = array(
            'status' => true,
            'data' => $generos
        );
    } else {
        $arr_Respuestas = array(
            'status' => false,
            'mensaje' => 'No se encontraron géneros'
        );
    }

    echo json_encode($arr_Respuestas, JSON_UNESCAPED_UNICODE);
}
