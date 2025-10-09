<?php
require_once('../model/clienteModel.php');
require_once('../model/tokenModel.php');

$tipo = $_REQUEST['tipo'];
$objCliente = new ClienteModel();
$objToken = new TokenModel();

/* === LISTAR CLIENTES === */
if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_clientes = $objCliente->obtener_clientes();

    if (!empty($arr_clientes)) {
        for ($i = 0; $i < count($arr_clientes); $i++) {
            $id_cliente = $arr_clientes[$i]->id;

            // Botones de acción
            $opciones = '
            <div class="d-flex justify-content-start gap-2">
                <a href="' . BASE_URL . 'editar-cliente/' . $id_cliente . '" 
                   class="btn btn-warning btn-sm px-4 d-inline-flex align-items-center">
                    <i class="fa fa-pencil"></i> Editar
                </a>
                <button onclick="eliminar_cliente(' . $id_cliente . ')" 
                        class="btn btn-danger btn-sm px-4 d-inline-flex align-items-center">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
            </div>';

            $arr_clientes[$i]->options = $opciones;
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_clientes;
    }

    echo json_encode($arr_Respuestas);
}


/* === REGISTRAR CLIENTE === */
if ($tipo == "registrar") {
    if ($_POST) {
        $dni      = $_POST['dni'];
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $correo   = $_POST['correo'];
        $estado   = $_POST['estado'];

        if ($dni == "" || $nombre == "" || $apellido == "" || $telefono == "" || $correo == "" || $estado == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $arrCliente = $objCliente->registrarCliente($dni, $nombre, $apellido, $telefono, $correo, $estado);

            if ($arrCliente['id'] > 0) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Cliente registrado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al registrar cliente');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === EDITAR CLIENTE === */
if ($tipo == "editar") {
    if ($_POST) {
        $id       = $_POST['id_cliente'];
        $dni      = $_POST['dni'];
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $correo   = $_POST['correo'];
        $estado   = $_POST['estado'];

        if ($id == "" || $dni == "" || $nombre == "" || $apellido == "" || $telefono == "" || $correo == "" || $estado == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $editado = $objCliente->editarCliente($id, $dni, $nombre, $apellido, $telefono, $correo, $estado);

            if ($editado) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Cliente actualizado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al actualizar cliente');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === VER CLIENTE (para precargar el form) === */
if ($tipo == "ver") {
    if ($_POST) {
        $id = $_POST['id_cliente'];
        $cliente = $objCliente->obtenerCliente($id);

        if ($cliente) {
            $arr_Respuestas = array('status' => true, 'contenido' => $cliente);
        } else {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Cliente no encontrado');
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === ELIMINAR CLIENTE === */
if ($tipo == "eliminar") {
    $id_cliente = $_POST['id_cliente'];

    try {
        $arr_Respuesta = $objCliente->eliminarCliente($id_cliente);

        if ($arr_Respuesta) {
            $response = array(
                'status' => true,
                'message' => 'Cliente eliminado correctamente.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'No se encontró el cliente o no pudo ser eliminado.'
            );
        }
    } catch (PDOException $e) {
        // Verificamos si el error es por clave foránea
        if ($e->getCode() == '23000') {
            $response = array(
                'status' => false,
                'message' => 'No se puede eliminar este cliente porque está asociado a otros registros.'
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



/* === apiiiiiiiiiiiiiiiiiii === */

if ($tipo == 'verPelicula') {
$token_arr = explode("-", $token);
$id_cliente = $token_arr[2];
$arr_cliente = $objCliente->obtenerCliente($id_cliente);
if ($arr_cliente ->estado) {
    $data = $_POST['data'];
    $arr_peliculas = $objCliente->buscarPeliculaPorNombre($data);
    $arr_Respuesta = array('status'=> true, 'msg'=>'' ,'contenido'=>$arr_peliculas);
    
}else {
     $arr_Respuesta = array('status'=> true, 'msg'=>'Error cliente no activo');
}

}
?>
