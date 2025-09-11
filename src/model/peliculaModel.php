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


    public function registrar_pelicula($titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero) {
    $sql = "INSERT INTO peliculas (titulo, descripcion, anio_estreno, duracion, calificacion, idioma, genero, creado_en, actualizado_en)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ssiisss", $titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero);

    if ($stmt->execute()) {
        return $stmt->insert_id; // devuelve el ID insertado
    } else {
        return 0;
    }
}

 public function registrarPelicula($titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero) {
        $sql = "INSERT INTO peliculas (titulo, descripcion, anio_estreno, duracion, calificacion, idioma, genero)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssissss", $titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero);
        
        if ($stmt->execute()) {
            return ['id' => $stmt->insert_id];
        } else {
            return ['id' => 0];
        }
    }

    // Obtener una película por ID
    public function obtenerPelicula($id) {
        $sql = "SELECT * FROM peliculas WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Editar película
    public function editarPelicula($id, $titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero) {
        $sql = "UPDATE peliculas 
                SET titulo = ?, descripcion = ?, anio_estreno = ?, duracion = ?, 
                    calificacion = ?, idioma = ?, genero = ?
                WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssissssi", $titulo, $descripcion, $anio_estreno, $duracion, $calificacion, $idioma, $genero, $id);
        return $stmt->execute();
    }

    public function eliminarPelicula($id) {
    $sql = "DELETE FROM peliculas WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

}
    

