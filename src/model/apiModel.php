<?php
require_once "../library/conexion.php";

class ApiModel
{
    private $conexion;

    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function buscarClienteById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM cliente_api WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
public function buscarPeliPorNombreYFiltro($nombre, $idioma, $genero) {
    $sql = "SELECT * FROM peliculas WHERE titulo LIKE '%$nombre%'";

    if (!empty($idioma)) {
        $sql .= " AND idioma = '$idioma'";
    }

    // Aquí usamos LIKE para buscar géneros dentro del texto
    if (!empty($genero)) {
        $sql .= " AND genero LIKE '%$genero%'";
    }

    $resultado = $this->conexion->query($sql);

    $peliculas = [];
    while ($row = $resultado->fetch_assoc()) {
        $peliculas[] = $row;
    }

    return $peliculas;
}

}

