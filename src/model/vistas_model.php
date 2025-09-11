<?php
session_start();
class vistaModelo
{
    
    protected static function obtener_vista($vista)
    {
        $palabras_permitidas = ['inicio','peliculas','nueva-peli','editar-pelicula'];

    if (!isset($_SESSION['sesion_ventas_id'])) {
        return "login";
    }
    
        if (in_array($vista, $palabras_permitidas)) {
            if (is_file("./src/views/".$vista.".php")) {
                $contenido = "./src/views/".$vista.".php";  
            } else {
                $contenido = "404";
            }
        } elseif ($vista == "login" || $vista == "index") {
            $contenido = "login";
        } else {
            $contenido = "404";
        }
        return $contenido;
    }
}