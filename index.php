<?php
    require_once './config/app.php';
    require_once './autoload.php';
    require_once './app/views/inc/session_start.php';
    if(isset($_GET['views'])){

        $url=explode("/",$_GET['views']);

    }else{
        $url=["login"];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once './app/views/inc/head.php';?>
</head>
<body>
    
    <?php 
    use app\Controllers\viewsController;
    use app\Controllers\loginController;

    $inicio_sesion = new loginController(); 
    $viewsController = new viewsController(); 
    $vista=$viewsController->obtenerVistasControllador($url[0]);
    if($vista =="login" || $vista == "404"){
       
        require_once "./app/views/content/".$vista."-view.php";
    }else{
        if(!isset($_SESSION['id_usuario']) || !isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] =="" ||$_SESSION['id_usuario'] == ""  ){
            $inicio_sesion->cerrarSesionController();
            exit();
        }
        require_once  "./app/views/inc/navbar.php";
        require_once $vista;
    }
    require_once './app/views/inc/script.php';?>
</body>
</html>