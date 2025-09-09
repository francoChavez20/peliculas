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

     // Registrar nueva película
    public function registrarPelicula($titulo, $descripcion, $anio_estreno, $duracion, $idioma, $calificacion) {
        $sql = "INSERT INTO peliculas (titulo, descripcion, anio_estreno, duracion, idioma, calificacion) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssisss", $titulo, $descripcion, $anio_estreno, $duracion, $idioma, $calificacion);

        if ($stmt->execute()) {
            return $stmt->insert_id; // devuelve el ID de la película creada
        }
        return 0;
    }

    // Asignar géneros a una película
    public function asignarGenero($pelicula_id, $genero_id) {
        $sql = "INSERT INTO pelicula_generos (pelicula_id, genero_id) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $pelicula_id, $genero_id);
        return $stmt->execute();
    }

    // Ver una película con sus géneros
    public function verPelicula($id) {
        $sql = $this->conexion->query("SELECT * FROM peliculas WHERE id = '$id'");
        $pelicula = $sql->fetch_object();

        if ($pelicula) {
            // Traer géneros relacionados desde la tabla generos
            $sqlGenero = $this->conexion->query("
                SELECT g.id, g.nombre 
                FROM pelicula_generos pg
                INNER JOIN generos g ON pg.genero_id = g.id
                WHERE pg.pelicula_id = '$id'
            ");
            $generos = [];
            while ($row = $sqlGenero->fetch_object()) {
                $generos[] = $row;
            }
            $pelicula->generos = $generos;
        }

        return $pelicula;
    }

    // Listar todas las películas con sus géneros
    public function listarPeliculas() {
        $sql = $this->conexion->query("SELECT * FROM peliculas ORDER BY anio_estreno DESC");
        $peliculas = [];

        while ($row = $sql->fetch_object()) {
            // Para cada película traer sus géneros
            $sqlGenero = $this->conexion->query("
                SELECT g.id, g.nombre 
                FROM pelicula_generos pg
                INNER JOIN generos g ON pg.genero_id = g.id
                WHERE pg.pelicula_id = '$row->id'
            ");
            $generos = [];
            while ($g = $sqlGenero->fetch_object()) {
                $generos[] = $g;
            }
            $row->generos = $generos;

            $peliculas[] = $row;
        }

        return $peliculas;
    }
}
