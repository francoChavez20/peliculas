<?php
require_once '../library/conexion.php';

class UsuarioModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::connect(); // Conexión mysqli
    }

    // Obtener todos los usuarios
    public function obtener_usuarios() {
        $arrRespuesta = array();
        $respuesta = $this->conexion->query("SELECT * FROM usuario");
        
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }

        return $arrRespuesta;
    }

    // Registrar usuario
    public function registrarUsuario($nombre, $apellido, $password, $rol) {
        $sql = "INSERT INTO usuario (nombre, apellido, password, rol, creado_en, actualizado_en)
                VALUES (?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $password, $rol);

        if ($stmt->execute()) {
            return ['id' => $stmt->insert_id];
        } else {
            return ['id' => 0];
        }
    }

    // Obtener un usuario por ID
    public function obtenerUsuario($id) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

  // Editar usuario (sin modificar contraseña)
public function editarUsuario($id, $nombre, $apellido, $rol) {
    $sql = "UPDATE usuario 
            SET nombre = ?, apellido = ?, rol = ?, actualizado_en = NOW()
            WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $apellido, $rol, $id);
    return $stmt->execute();
}


    // Eliminar usuario
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
