<?php

require_once '../../config/app.php';
require_once '../views/inc/session_start.php';
require_once '../../autoload.php';

use app\Controllers\usuarioController;

if(isset($_POST["modulo_usuario"])){
    $usuario_nuevo = new usuarioController();
    if($_POST["modulo_usuario"] =="registrar"){
        echo $usuario_nuevo->registrarUsuarioController();
    }
    if($_POST["modulo_usuario"] =="eliminar"){
        echo $usuario_nuevo->eliminarUsuarioController();
    } 
    if($_POST["modulo_usuario"] =="actualizar"){
        echo $usuario_nuevo->actualizarUsuarioController();
    }    
}else{
    session_destroy();
    header("Location: ".APP_URL."login/");
}
/*$usuario_nuevo = new usuarioController();
echo $usuario_nuevo->registrarUsuarioController();*/
