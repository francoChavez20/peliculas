<?php
require_once '../library/conexion.php';

class ClienteModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::connect(); // Conexión mysqli
    }

    // Obtener todos los clientes
public function obtener_clientes() {
    $arrRespuesta = array();
    $sql = "SELECT id, dni, nombre, apellido, telefono, correo,`fecha-registro`,
                   CASE 
                       WHEN estado = 1 THEN 'Activo' 
                       ELSE 'Inactivo' 
                   END AS estado
            FROM `cliente-api`";

    $respuesta = $this->conexion->query($sql);
    while ($objeto = $respuesta->fetch_object()) {
        array_push($arrRespuesta, $objeto);
    }

    return $arrRespuesta;
}



    // Registrar cliente
    public function registrarCliente($dni, $nombre, $apellido, $telefono, $correo, $estado) {
        $sql = "INSERT INTO `cliente-api` 
                (dni, nombre, apellido, telefono, correo, `fecha-registro`, estado) 
                VALUES (?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssi", $dni, $nombre, $apellido, $telefono, $correo, $estado);

        if ($stmt->execute()) {
            return ['id' => $stmt->insert_id];
        } else {
            return ['id' => 0];
        }
    }

    // Obtener un cliente por ID
    public function obtenerCliente($id) {
        $sql = "SELECT * FROM `cliente-api` WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Editar cliente
    public function editarCliente($id, $dni, $nombre, $apellido, $telefono, $correo, $estado) {
        $sql = "UPDATE `cliente-api` 
                SET dni = ?, nombre = ?, apellido = ?, telefono = ?, correo = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssii", $dni, $nombre, $apellido, $telefono, $correo, $estado, $id);
        return $stmt->execute();
    }

    // Eliminar cliente
    public function eliminarCliente($id) {
        $sql = "DELETE FROM `cliente-api` WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getClientes() {
    $sql = "SELECT id, nombre, apellido FROM `cliente-api` ORDER BY nombre ASC";
    $result = $this->conexion->query($sql);

    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    return $clientes;
}







}
?>
