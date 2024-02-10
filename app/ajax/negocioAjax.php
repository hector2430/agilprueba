<?php

require_once '../../config/app.php';
require_once '../views/inc/session_start.php';
require_once '../../autoload.php';

use app\Controllers\negocioController;

if(isset($_POST["modulo_negocio"])){
    $negocio = new negocioController();
    if($_POST["modulo_negocio"] =="registrar"){
        echo $negocio->registrarNegocioController();
    }
    if($_POST["modulo_negocio"] =="eliminar"){
        echo $negocio->eliminarNegocioController();
    } 
    if($_POST["modulo_negocio"] =="actualizar"){
        echo $negocio->actualizarNegocioController();
    }    
}else{
    session_destroy();
    header("Location: ".APP_URL."login/");
}
/*$usuario_nuevo = new usuarioController();
echo $usuario_nuevo->registrarUsuarioController();*/
