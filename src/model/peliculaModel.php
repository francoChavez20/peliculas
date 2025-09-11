<?php
require_once '../library/conexion.php';

class PeliculaModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::connect(); // Obtenemos la conexión mysqli
    }

       public function obtener_peliculas() {
        $arrRespuesta = array();
        $respuesta = $this->conexion->query("SELECT * FROM peliculas");
        
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }

        return $arrRespuesta;
    }

    
}
