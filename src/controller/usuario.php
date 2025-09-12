<?php
require_once('../model/usuarioModel.php');

$tipo = $_REQUEST['tipo'];
$objUsuario = new UsuarioModel();

/* === LISTAR USUARIOS === */
if ($tipo == "listar") {
    $arr_Respuestas = array('status' => false, 'contenido' => '');
    $arr_usuarios = $objUsuario->obtener_usuarios();

    if (!empty($arr_usuarios)) {
        for ($i = 0; $i < count($arr_usuarios); $i++) {
            $id_usuario = $arr_usuarios[$i]->id;

            // Botones de acción
            $opciones = '
            <div class="d-flex justify-content-start gap-2">
    <a href="' . BASE_URL . 'editar-usuario/' . $id_usuario . '" 
       class="btn btn-warning btn-sm px-4 d-inline-flex align-items-center">
        <i class="fa fa-pencil"></i> Editar
    </a>
</div>
';


            $arr_usuarios[$i]->options = $opciones;
        }

        $arr_Respuestas['status'] = true;
        $arr_Respuestas['contenido'] = $arr_usuarios;
    }

    echo json_encode($arr_Respuestas);
}


/* === REGISTRAR USUARIO === */
if ($tipo == "registrar") {
    if ($_POST) {
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $password = $_POST['password'];
        $rol      = $_POST['rol'];

        if ($nombre == "" || $apellido == "" || $password == "" || $rol == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            $arrUsuario = $objUsuario->registrarUsuario($nombre, $apellido, $password, $rol);

            if ($arrUsuario['id'] > 0) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Usuario registrado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al registrar usuario');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === EDITAR USUARIO === */
if ($tipo == "editar") {
    if ($_POST) {
        $id       = $_POST['id_usuario'];
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $rol      = $_POST['rol'];

        if ($id == "" || $nombre == "" || $apellido == "" || $rol == "") {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Error, campos vacíos');
        } else {
            // Solo se actualizan nombre, apellido y rol
            $editado = $objUsuario->editarUsuario($id, $nombre, $apellido, $rol);

            if ($editado) {
                $arr_Respuestas = array('status' => true, 'mensaje' => 'Usuario actualizado con éxito');
            } else {
                $arr_Respuestas = array('status' => false, 'mensaje' => 'Error al actualizar usuario');
            }
        }
        echo json_encode($arr_Respuestas);
    }
}



/* === VER USUARIO (para precargar el form) === */
if ($tipo == "ver") {
    if ($_POST) {
        $id = $_POST['id_usuario'];
        $usuario = $objUsuario->obtenerUsuario($id);

        if ($usuario) {
            $arr_Respuestas = array('status' => true, 'contenido' => $usuario);
        } else {
            $arr_Respuestas = array('status' => false, 'mensaje' => 'Usuario no encontrado');
        }
        echo json_encode($arr_Respuestas);
    }
}


/* === ELIMINAR USUARIO === */
if ($tipo == "eliminar") {
    $id_usuario = $_POST['id_usuario'];

    try {
        $arr_Respuesta = $objUsuario->eliminarUsuario($id_usuario);

        if ($arr_Respuesta) {
            $response = array(
                'status' => true,
                'message' => 'Usuario eliminado correctamente.'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'No se encontró el usuario o no pudo ser eliminado.'
            );
        }
    } catch (PDOException $e) {
        // Verificamos si el error es por clave foránea
        if ($e->getCode() == '23000') {
            $response = array(
                'status' => false,
                'message' => 'No se puede eliminar este usuario porque está asociado a otros registros.'
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
?>
