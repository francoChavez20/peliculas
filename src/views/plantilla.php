<?php
require_once "./src/config/config.php";
require_once "./src/controller/vistas_control.php";

$mostrar =  new vistascontrolador();

$vista = $mostrar->obtenerVistaControlador();
if ($vista=="login" || $vista == "404"|| $vista == "api-request") {
    require_once "./src/views/".$vista.".php";
}else{
    include_once "./src/views/include/header.php";
    include $vista;
    include_once "./src/views/include/footer.php";
}

 ?>