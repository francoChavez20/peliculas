<?php
  require_once "./src/model/vistas_model.php";

  class vistasControlador extends vistaModelo{
    public function obtenerPlantillaControlador(){
        return require_once "./src/views/plantilla.php";
    }
    public function obtenerVistaControlador(){
        //views de archivo htacces
        if (isset($_GET['views'])){
            
            $ruta = explode("/",$_GET['views']);
            $respuesta = vistaModelo::obtener_vista( $ruta[0]);
        }else{
            $respuesta = "login";
        }
        return $respuesta;
    }
  }

 ?>