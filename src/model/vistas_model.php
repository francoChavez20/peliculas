<?php
session_start();
class vistaModelo
{
    
    protected static function obtener_vista($vista)
    {
        $palabras_permitidas = ['inicio','peliculas','nueva-peli','editar-pelicula','usuario','nuevo-usuario','editar-usuario','cliente','nuevo-cliente','editar-cliente','token','nuevo-token','editar-token'];

    if (!isset($_SESSION['sesion_ventas_id'])) {
        return "login";
    }
    
        if (in_array($vista, $palabras_permitidas)) {

            if (is_file("./src/views/".$vista.".php")) {
                $contenido = "./src/views/".$vista.".php";  
            } else {
                $contenido = "404";
            }
        } elseif ($vista == "inicio" || $vista == "index") {
            $contenido = "inicio.php";
        } elseif ($vista == "login") {
            $contenido = "login";
        } elseif ($vista == "api-request") {
            $contenido = "api-request";
        } else {
            $contenido = "404";
        }

        return $contenido;
    }
}