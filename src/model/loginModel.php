<?php
require_once "../library/conexion.php";

class loginModel
{
    private $conexion;

    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    // Nuevo: buscar por usuario
    public function buscarPersonaPorUsuario($usuario)
    {
        $sql = $this->conexion->query("SELECT * FROM usuario WHERE nombre = '{$usuario}'");
        $sql = $sql->fetch_object();
        return $sql;
    }


}
