<?php

require_once '../../config/app.php';
require_once '../views/inc/session_start.php';
require_once '../../autoload.php';

use app\Controllers\giroController;

if(isset($_POST["modulo_giro"])){
    $negocio = new giroController();
    if($_POST["modulo_giro"] =="registrar"){
        echo $negocio->registrarGiroController();
    }
    if($_POST["modulo_giro"] =="eliminar"){
        echo $negocio->eliminarGiroController();
    } 
    if($_POST["modulo_giro"] =="actualizar"){
        echo $negocio->actualizarGiroController();
    }    
}else{
    session_destroy();
    header("Location: ".APP_URL."login/");
}
/*$usuario_nuevo = new usuarioController();
echo $usuario_nuevo->registrarUsuarioController();*/
