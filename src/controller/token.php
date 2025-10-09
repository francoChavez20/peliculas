<?php
require_once('../model/tokenModel.php');

$tipo = $_REQUEST['tipo'];
$objToken = new TokenModel();

/* === LISTAR TOKENS === */
if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_tokens = $objToken->obtener_tokens();

    if (!empty($arr_tokens)) {
        foreach ($arr_tokens as $i => $row) {
            $id_token = $row->id;

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
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_tokens;
    }

    echo json_encode($arr_Respuestas);
}


/* === LISTAR CLIENTES PARA EL SELECT === */
if ($tipo == "listarClientes") {
    $clientes = $objToken->obtener_clientes();
    echo json_encode(['status' => true, 'contenido' => $clientes]);
}


/* === REGISTRAR TOKEN === */
if ($tipo == "registrar") {
    if ($_POST) {
        $idCliente = $_POST['id_cliente'];
        $estado    = $_POST['estado'];

        if ($idCliente == "" || $estado == "") {
            $arr_Respuestas = array(
                'status' => false,
                'mensaje' => 'Error, campos vacíos'
            );
        } else {
            // Ahora solo pasamos cliente y estado
            $arrToken = $objToken->registrarToken($idCliente, $estado);

            if (isset($arrToken['id']) && $arrToken['id'] > 0) {
                $arr_Respuestas = array(
                    'status'  => true,
                    'mensaje' => 'Token registrado con éxito',
                    'token'   => $arrToken['token'],
                    'fecha'   => $arrToken['fecha'],
                    'id'      => $arrToken['id']
                );
            } else {
                $arr_Respuestas = array(
                    'status' => false,
                    'mensaje' => 'Error al registrar token'
                );
            }
        }
        echo json_encode($arr_Respuestas);
    }
}

/* === EDITAR TOKEN === */
if ($tipo == "editar") {
    if ($_POST) {
        $id = $_POST['id_token'];
        $idCliente = $_POST['id_cliente_api'];
        $token = $_POST['token'];
        $estado = $_POST['estado'];
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
} /* === VER TOKEN (precargar form) === */
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
} /* === ELIMINAR TOKEN === */
if ($tipo == "eliminar") {
    $id_token = $_POST['id_token'];
    try {
        $arr_Respuesta = $objToken->eliminarToken($id_token);
        if ($arr_Respuesta) {
            $response = array('status' => true, 'message' => 'Token eliminado correctamente.');
        } else {
            $response = array('status' => false, 'message' => 'No se encontró el token o no pudo ser eliminado.');
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            $response = array('status' => false, 'message' => 'No se puede eliminar este token porque está asociado a otros registros.');
        } else {
            $response = array('status' => false, 'message' => 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
    echo json_encode($response);
}
