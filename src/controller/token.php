<?php
require_once('../model/tokenModel.php');

$tipo = $_REQUEST['tipo'];
$objToken = new TokenModel();

/* === LISTAR TOKENS === */
if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_tokens = $objToken->obtener_tokens();

    if (!empty($arr_tokens)) {
        for ($i = 0; $i < count($arr_tokens); $i++) {
            $id_token = $arr_tokens[$i]->id;

            // Botones de acción
            $opciones = '
            <div class="d-flex justify-content-start gap-2">
                <a href="' . BASE_URL . 'editar-token/' . $id_token . '" 
                   class="btn btn-warning btn-sm px-4 d-inline-flex align-items-center">
                    <i class="fa fa-pencil"></i> Editar
                </a>
                <button onclick="eliminar_token(' . $id_token . ')" 
                        class="btn btn-danger btn-sm px-4 d-inline-flex align-items-center">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
            </div>';

            $arr_tokens[$i]->options = $opciones;

            // Mostrar estado como Activo/Inactivo
            $arr_tokens[$i]->estado = ($arr_tokens[$i]->estado == 1) ? 'Activo' : 'Inactivo';
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_tokens;
    }

    echo json_encode($arr_Respuestas);
}


/* === REGISTRAR TOKEN === */
if ($tipo == "registrar") {
    if ($_POST) {
        $idCliente = $_POST['id_cliente'];
        $token     = $_POST['token'];
        $estado    = $_POST['estado'];

        if ($idCliente == "" || $token == "" || $estado == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $arrToken = $objToken->registrarToken($idCliente, $token, $estado);

            if ($arrToken['id'] > 0) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Token registrado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al registrar token');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === EDITAR TOKEN === */
if ($tipo == "editar") {
    if ($_POST) {
        $id        = $_POST['id_token'];
        $idCliente = $_POST['id_cliente'];
        $token     = $_POST['token'];
        $estado    = $_POST['estado'];

        if ($id == "" || $idCliente == "" || $token == "" || $estado == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $editado = $objToken->editarToken($id, $idCliente, $token, $estado);

            if ($editado) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Token actualizado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al actualizar token');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === VER TOKEN (precargar form) === */
if ($tipo == "ver") {
    if ($_POST) {
        $id = $_POST['id_token'];
        $token = $objToken->obtenerToken($id);

        if ($token) {
            $arr_Respuestas = array('status' => true, 'contenido' => $token);
        } else {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Token no encontrado');
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === ELIMINAR TOKEN === */
if ($tipo == "eliminar") {
    $id_token = $_POST['id_token'];

    try {
        $arr_Respuesta = $objToken->eliminarToken($id_token);

        if ($arr_Respuesta) {
            $response = array(
                'status' => true,
                'message' => 'Token eliminado correctamente.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'No se encontró el token o no pudo ser eliminado.'
            );
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            $response = array(
                'status' => false,
                'message' => 'No se puede eliminar este token porque está asociado a otros registros.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            );
        }
    }

    echo json_encode($response);
}
