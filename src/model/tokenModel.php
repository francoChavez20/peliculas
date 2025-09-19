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
        $sql = "SELECT id, `id-cliente-api`, token, `fecha-registro`,
                       CASE 
                           WHEN estado = 1 THEN 'Activo' 
                           ELSE 'Inactivo' 
                       END AS estado
                FROM `tokens`";

        $respuesta = $this->conexion->query($sql);
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }

    /* === REGISTRAR TOKEN === */
    public function registrarToken($id_cliente_api, $token, $estado) {
        $sql = "INSERT INTO `tokens`
                (`id-cliente-api`, token, `fecha-registro`, estado) 
                VALUES (?, ?, NOW(), ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("isi", $id_cliente_api, $token, $estado);

        if ($stmt->execute()) {
            return ['id' => $stmt->insert_id];
        } else {
            return ['id' => 0];
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
                SET `id-cliente-api` = ?, token = ?, estado = ?
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
