<?php

require_once '../../config/app.php';
require_once '../views/inc/session_start.php';
require_once '../../autoload.php';

use app\Controllers\servicioController;

if(isset($_POST["modulo_servicio"])){
    $servicio = new servicioController();
    if($_POST["modulo_servicio"] =="registrar"){
        echo $servicio->registrarServicioController();
    }
    if($_POST["modulo_servicio"] =="eliminar"){
        echo $servicio->eliminaServicioController();
    } 
    if($_POST["modulo_servicio"] =="actualizar"){
        echo $servicio->actualizarServicioController();
    }    
}else{
    session_destroy();
    header("Location: ".APP_URL."login/");
}
/*$usuario_nuevo = new usuarioController();
echo $usuario_nuevo->registrarUsuarioController();*/
