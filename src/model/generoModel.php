<?php
require_once '../library/conexion.php';

class GeneroModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::connect();
    }

    // Obtener todos los géneros de una película (muchos a muchos)
    public function obtener_generos_por_pelicula($id_pelicula) {
        $sql = "SELECT g.nombre 
                FROM generos g
                INNER JOIN pelicula_generos pg ON g.id = pg.genero_id
                WHERE pg.pelicula_id = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pelicula); // "i" = integer
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $generos = [];
        while ($row = $resultado->fetch_assoc()) {
            $generos[] = $row['nombre'];
        }

        $stmt->close();
        return $generos; // array de nombres
    }

    // Obtener todos los géneros (para selects)
    public function obtener_todos_generos() {
        $sql = "SELECT id, nombre FROM generos ORDER BY nombre";
        $resultado = $this->conexion->query($sql);
        $generos = [];

        if ($resultado) {
            while ($row = $resultado->fetch_object()) {
                $generos[] = $row;
            }
        }

        return $generos;
    }

    // Listar todos los géneros
    public function listarGeneros() {
        $sql = $this->conexion->query("SELECT id, nombre FROM generos ORDER BY nombre ASC");
        $generos = [];
        while ($row = $sql->fetch_object()) {
            $generos[] = $row;
        }
        return $generos;
    }
}
