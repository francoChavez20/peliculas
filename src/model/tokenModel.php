<?php
require_once '../library/conexion.php';

class TokenModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::connect(); 
    }

    /* === LISTAR TOKENS === */
    public function obtener_tokens() {
        $arrRespuesta = array();
        $sql = "SELECT t.id, 
                       t.`id_cliente_api`, 
                       c.nombre AS cliente, 
                       t.token, 
                       t.fecha_registro,
                       CASE 
                           WHEN t.estado = 1 THEN 'Activo' 
                           ELSE 'Inactivo' 
                       END AS estado
                FROM `tokens` t
                INNER JOIN `cliente_api` c ON t.`id_cliente_api` = c.id";

        $respuesta = $this->conexion->query($sql);
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }

    /* === LISTAR CLIENTES === */
    public function obtener_clientes() {
        $arrRespuesta = array();
        $sql = "SELECT id, nombre FROM `cliente_api` ORDER BY nombre ASC";
        $respuesta = $this->conexion->query($sql);
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }

   public function registrarToken($id_cliente_api, $estado) {
    // Insertamos primero con un token vacío
    $sql = "INSERT INTO `tokens`(`id_cliente_api`, `token`, `fecha_registro`, `estado`) 
            VALUES (?, '', NOW(), ?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ii", $id_cliente_api, $estado);

    if ($stmt->execute()) {
        $idInsertado = $stmt->insert_id;

        // Generar el token personalizado
        $random = substr(md5(uniqid()), 0, 15); // Parte aleatoria
        $fecha  = date("Ymd");
        $tokenFinal = $random . "-" . $fecha . "-" . $idInsertado;

        // Actualizar el token en el registro recién insertado
        $update = $this->conexion->prepare("UPDATE `tokens` SET token = ? WHERE id = ?");
        $update->bind_param("si", $tokenFinal, $idInsertado);
        $update->execute();

        return ['id' => $idInsertado, 'token' => $tokenFinal, 'fecha' => $fecha];
    } else {
        return ['id' => 0, 'error' => $stmt->error];
    }
}


    /* === OBTENER TOKEN POR ID === */
    public function obtenerToken($id) {
        $sql = "SELECT * FROM `tokens` WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    /* === EDITAR TOKEN === */
    public function editarToken($id, $id_cliente_api, $token, $estado) {
        $sql = "UPDATE `tokens` 
                SET `id_cliente_api` = ?, token = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("isii", $id_cliente_api, $token, $estado, $id);
        return $stmt->execute();
    }

    /* === ELIMINAR TOKEN === */
    public function eliminarToken($id) {
        $sql = "DELETE FROM `tokens` WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
