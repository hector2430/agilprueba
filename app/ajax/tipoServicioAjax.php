<?php

require_once '../../config/app.php';
require_once '../views/inc/session_start.php';
require_once '../../autoload.php';

use app\Controllers\tipo_servicio_Controller;

if(isset($_POST["modulo_tipo_servicio"])){
    $tipo_servicio = new tipo_servicio_Controller();
    if($_POST["modulo_tipo_servicio"] =="registrar"){
        echo $negocio->registrarTipoServicioController();
    }
    if($_POST["modulo_tipo_servicio"] =="eliminar"){
        echo $negocio->eliminaTipoServicioController();
    } 
    if($_POST["modulo_tipo_servicio"] =="actualizar"){
        echo $negocio->actualizarTipoServicioController();
    }    
}else{
    session_destroy();
    header("Location: ".APP_URL."login/");
}
/*$usuario_nuevo = new usuarioController();
echo $usuario_nuevo->registrarUsuarioController();*/
